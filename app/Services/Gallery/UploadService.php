<?php

namespace App\Services\Gallery;

use App\Facades\Limit;
use App\Http\Resources\GalleryFile;
use App\Models\Image;
use App\Sanitizers\SvgAllowedAttributes;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UploadService
{
    use CampaignAware;
    use UserAware;

    protected FormRequest $request;

    protected array $data;

    protected Image $image;

    protected string $folder;

    protected StorageService $storage;

    protected int $available;

    public function __construct(StorageService $storageService)
    {
        $this->storage = $storageService;
    }

    public function request(FormRequest $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function image(): Image
    {
        return $this->image;
    }

    public function folder(string $folder): self
    {
        if (empty($folder)) {
            unset($this->folder);

            return $this;
        }
        $this->folder = $folder;

        return $this;
    }

    public function data(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function file(UploadedFile $file): array
    {
        $this->image = new Image;
        $this->image->campaign_id = $this->campaign->id;
        $this->image->name = Str::beforeLast($file->getClientOriginalName(), '.');
        $this->image->ext = Str::before($file->extension(), '?');
        $this->image->size = (int) ceil($file->getSize() / 1024); // kb
        $this->image->visibility_id = $this->campaign->defaultGalleryVisibility();
        if (isset($this->folder)) {
            $this->image->folder_id = $this->folder;
        }
        $this->image->save();

        $file->storePubliclyAs($this->image->folder, $this->image->file);
        $this->storage->campaign($this->campaign)->clearCache();

        return $this->format();
    }

    public function files(array $files): array
    {
        $data = [];
        $available = $this->storage->campaign($this->campaign)->available();
        foreach ($files as $file) {
            // If we have enough space
            $kb = (int) ceil($file->getSize() / 1024);
            if ($kb > $available) {
                continue;
            }
            $this->file($file);
            $available -= $kb;
            $data[] = (new GalleryFile($this->image))->campaign($this->campaign);
        }

        return $data;
    }

    public function url(string $url): array
    {
        $this->image = new Image;

        $externalFile = basename($url);

        $tempImage = tempnam(sys_get_temp_dir(), $externalFile);
        try {
            copy($url, $tempImage);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([__('gallery.download.errors.copy_failed')]);
        }

        $cleanImageName = Str::slug(
            Str::before(
                Str::before($externalFile, '%3F'),
                '?'
            )
        );
        $cleanImageName = str_replace(['.', '/'], ['', ''], $cleanImageName);

        // Check if file is too big
        $copiedFileSize = ceil(filesize($tempImage) / 1024);
        if ($this->request->has('map')) {
            Limit::map();
        }
        $max = Limit::upload();
        if ($copiedFileSize > $max) {
            unlink($tempImage);
            throw ValidationException::withMessages([__('gallery.download.errors.too_big', [
                'size' => number_format($copiedFileSize / 1024, 2),
                'max' => number_format($max / 1024, 2),
            ])]);
        }
        $available = $this->storage->campaign($this->campaign)->available();
        if ($copiedFileSize > $available) {
            unlink($tempImage);
            $key = 'gallery.download.errors.gallery_full_free';
            if ($this->campaign->boosted()) {
                $key = 'gallery.download.errors.gallery_full_premium';
            }
            throw ValidationException::withMessages([__($key)]);
        }
        $file = new UploadedFile($tempImage, basename($url));

        // Invalid file type?
        $ext = mb_strtolower($file->guessExtension());
        if (! in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp'])) {
            unlink($tempImage);
            $key = 'gallery.download.errors.invalid_format';
            throw ValidationException::withMessages([__($key)]);
        }

        $this->image->name = $cleanImageName;
        $this->image->campaign_id = $this->campaign->id;
        $this->image->ext = $file->guessExtension();
        $this->image->size = (int) ceil($copiedFileSize); // kb
        $this->image->visibility_id = $this->campaign->defaultGalleryVisibility();
        if (isset($this->folder)) {
            $this->image->folder_id = $this->folder;
        }
        $this->image->save();

        if ($this->image->isSvg()) {
            // GD can't handle svgs, so we need to move them directly
            Storage::put($this->image->path, $this->sanitizedSvg($file), 'public');
        } else {
            $manager = new ImageManager(
                new Driver
            );
            $image = $manager->read($file);
            Storage::put($this->image->path, (string) $image->toJpeg(), 'public');
        }
        unlink($tempImage);
        $this->storage->clearCache();

        return $this->format();
    }

    protected function sanitizedSvg(string $path): string
    {
        $sanitizer = new Sanitizer;

        // Custom allowed attributes for AFMG
        $allowedAttributes = new SvgAllowedAttributes;
        $sanitizer->setAllowedAttrs($allowedAttributes);

        $dirtySVG = file_get_contents($path);
        $cleanSVG = $sanitizer->sanitize($dirtySVG);
        file_put_contents($path, $cleanSVG);

        return $cleanSVG;
    }

    protected function format(): array
    {
        return [
            'id' => $this->image->id,
            'name' => $this->image->name,
            'uuid' => $this->image->id,
            'path' => $this->image->path,
            'thumbnail' => $this->image->getUrl(192, 144),
        ];
    }
}
