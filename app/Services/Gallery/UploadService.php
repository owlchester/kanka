<?php

namespace App\Services\Gallery;

use App\Facades\Limit;
use App\Models\Image;
use App\Sanitizers\SvgAllowedAttributes;
use App\Services\Campaign\GalleryService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UploadService
{
    use CampaignAware;
    use UserAware;

    protected FormRequest $request;
    protected array $data;

    protected Image $image;

    protected GalleryService $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    public function request(FormRequest $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function data(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function file(UploadedFile $file): array
    {
        $this->image = new Image();
        $this->image->id = Str::uuid()->toString();
        $this->image->campaign_id = $this->campaign->id;
        $this->image->created_by = $this->user->id;
        $this->image->name = Str::beforeLast($file->getClientOriginalName(), '.');
        $this->image->ext = Str::before($file->extension(), '?');
        $this->image->size = (int) ceil($file->getSize() / 1024); // kb
        $this->image->visibility_id = $this->campaign->defaultVisibilityID();
        $this->image->save();

        $file->storePubliclyAs($this->image->folder, $this->image->file);

        return $this->format();
    }

    public function url(string $url): array
    {
        $this->image = new Image();
        $this->image->id = Str::uuid()->toString();

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
        if ($copiedFileSize > Limit::upload()) {
            unlink($tempImage);
            throw ValidationException::withMessages([__('gallery.download.errors.too_big')]);
        }
        $available = $this->galleryService->campaign($this->campaign)->available();
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
        if (!in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp'])) {
            unlink($tempImage);
            $key = 'gallery.download.errors.invalid_format';
            throw ValidationException::withMessages([__($key)]);
        }

        $this->image->name = $cleanImageName;
        $this->image->campaign_id = $this->campaign->id;
        $this->image->created_by = $this->user->id;
        $this->image->ext = Str::before($file->getExtension(), '?');
        $this->image->size = (int) ceil($copiedFileSize); // kb
        $this->image->visibility_id = $this->campaign->defaultVisibilityID();
        $this->image->save();

        if ($this->image->isSvg()) {
            // GD can't handle svgs, so we need to move them directly
            Storage::put($this->image->path, $this->sanitizedSvg($file), 'public');
        } else {
            $image = \Intervention\Image\Facades\Image::make($file);
            Storage::put($this->image->path, (string)$image->encode(), 'public');
        }
        unlink($tempImage);

        return $this->format();
    }

    protected function sanitizedSvg(string $path): string
    {
        $sanitizer = new Sanitizer();

        // Custom allowed attributes for AFMG
        $allowedAttributes = new SvgAllowedAttributes();
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
            'thumbnail' => $this->image->getUrl(192, 144)
        ];
    }
}
