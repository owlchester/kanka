<?php

namespace App\Services;

use App\Facades\Limit;
use App\Models\Entity;
use App\Sanitizers\SvgAllowedAttributes;
use App\Traits\CampaignAware;
use enshrined\svgSanitize\Sanitizer;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImagesService
{
    use CampaignAware;

    protected Model $model;

    protected string $field = 'image';

    protected string $folder;

    public function model(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function field(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function folder(string $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    public function handle()
    {
        // Remove the old image
        if (request()->post('remove-' . $this->field) == '1') {
            $this->cleanup($this->model, $this->field);

            return;
        }

        // No new image
        if (! request()->has($this->field) && ! request()->filled($this->field . '_url')) {
            return;
        }

        try {
            $cleanSVG = null;
            $url = request()->filled($this->field . '_url');

            // Download the file locally to check it out
            if ($url) {
                $externalUrl = request()->input($this->field . '_url');
                $externalFile = basename($externalUrl);

                $tempImage = tempnam(sys_get_temp_dir(), $externalFile);
                copy($externalUrl, $tempImage);

                $file = $tempImage;
                // Clean up the file name because weird letters can confuse thumbor
                // $cleanImageName = Str::replace('&', '', $externalFile);
                $cleanImageName = Str::slug(
                    Str::before(
                        Str::before($externalFile, '%3F'),
                        '?'
                    )
                );
                $cleanImageName = str_replace(['.', '/'], ['', ''], $cleanImageName);
                $path = "{$this->folder}/" . uniqid() . '_' . Str::limit($cleanImageName, 20, '');

                // Check if file is too big
                $copiedFileSize = ceil(filesize($tempImage) / 1000);
                if ($copiedFileSize > Limit::upload()) {
                    unlink($tempImage);
                    throw new Exception('image_url target too big');
                }
                $file = new UploadedFile($tempImage, basename($externalUrl));

                // Add back the extension if it's missing after trimming long names
                $imageUrlExt = '.' . str_replace('image/', '', $file->getMimeType());
                if (! Str::endsWith($path, $imageUrlExt)) {
                    $path = $path . mb_strtolower($imageUrlExt);
                }
            } else {
                $file = request()->file($this->field);
                $path = $file->hashName($this->folder);
            }

            // Sanitize SVGs to avoid any XSS attacks
            if ($file->getMimeType() == 'image/svg+xml') {
                $sanitizer = new Sanitizer;

                // Custom allowed attributes for AFMG
                $allowedAttributes = new SvgAllowedAttributes;
                $sanitizer->setAllowedAttrs($allowedAttributes);

                $dirtySVG = file_get_contents($file);
                $cleanSVG = $sanitizer->sanitize($dirtySVG);
                file_put_contents($file, $cleanSVG);
            }

            if (! empty($path)) {
                // Remove old
                $this->cleanup($this->model, $this->field);

                // Save the new image
                if ($url) {
                    if ($file->getMimeType() == 'image/svg+xml') {
                        // GD can't handle svgs, so we need to move them directly
                        Storage::put($path, $cleanSVG, 'public');
                    } else {
                        $manager = new ImageManager(
                            new Driver
                        );
                        $image = $manager->read($file);
                        Storage::put($path, (string) $image->toJpeg(), 'public');
                    }
                } else {
                    $path = request()->file($this->field)->storePublicly($this->folder);
                }
                if ($this->model instanceof Entity) {
                    $this->model->image_path = $path;
                } else {
                    $this->model->{$this->field} = $path;
                }
            }
        } catch (Exception $e) {
            // throw $e;
            // There was an error getting the image. Could be the url, could be the request.
            session()->flash('warning', trans('crud.image.error', ['size' => Limit::readable()->upload()]));
        }
    }

    /**
     * Delete old image and thumb
     */
    public function cleanup()
    {
        if ($this->model instanceof Entity && $this->field === 'image') {
            $this->field = 'image_path';
        }
        if (empty($this->model->{$this->field})) {
            return;
        }

        try {
            Storage::delete($this->model->{$this->field});
            // Leave removing thumbs for old campaigns
            $thumb = str_replace('.', '_thumb.', $this->model->{$this->field});
            if (Storage::has($thumb)) {
                Storage::delete($thumb);
            }
            // If it's a map, reset its height to be re-calculated
            if ($this->model instanceof Entity && $this->model->isMap()) {
                $this->model->map->height = null;
                $this->model->map->width = null;
                $this->model->map->saveQuietly();
            }
        } catch (Exception $e) {
            // silence exception, didn't find the image to delete.
        }
        $this->model->{$this->field} = null;
    }
}
