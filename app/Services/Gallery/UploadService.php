<?php

namespace App\Services\Gallery;

use App\Exceptions\TranslatableException;
use App\Facades\Limit;
use App\Models\Image;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
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

    protected Image $image;

    public function request(FormRequest $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function file(): array
    {
        $file = $this->request->file('file');

        $this->image = new Image();
        $this->image->id = Str::uuid()->toString();
        $this->image->name = Str::beforeLast($file->getClientOriginalName(), '.');;
        $this->image->campaign_id = $this->campaign->id;
        $this->image->created_by = $this->request->user()->id;
        $this->image->ext = Str::before($file->extension(), '?');
        $this->image->size = (int) ceil($file->getSize() / 1024); // kb
        $this->image->visibility_id = $this->campaign->defaultVisibilityID();
        $this->image->save();

        $file->storePubliclyAs($this->image->folder, $this->image->file);

        return $this->format();
    }

    public function url(): array
    {
        $this->image = new Image();
        $this->image->id = Str::uuid()->toString();

        $url = $this->request->get('url');
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
        $copiedFileSize = ceil(filesize($tempImage) / 1000);
        if ($copiedFileSize > Limit::upload()) {
            unlink($tempImage);
            throw ValidationException::withMessages([__('gallery.download.errors.too_big')]);
        }
        $file = new UploadedFile($tempImage, basename($url));

        // Invalid file type?

        $this->image->name = $cleanImageName;
        $this->image->campaign_id = $this->campaign->id;
        $this->image->created_by = $this->request->user()->id;
        $this->image->ext = Str::before($file->getExtension(), '?');
        $this->image->size = (int) ceil($copiedFileSize); // kb
        $this->image->visibility_id = $this->campaign->defaultVisibilityID();
        $this->image->save();


        $image = \Intervention\Image\Facades\Image::make($file);
        Storage::put($this->image->path, (string)$image->encode(), 'public');
        unlink($tempImage);

        return $this->format();
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
