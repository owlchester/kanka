<?php

namespace App\Services;

use App\Facades\Limit;
use App\Models\Entity;
use App\Models\Map;
use App\Models\MiscModel;
use App\Sanitizers\SvgAllowedAttributes;
use App\Traits\EntityAware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use enshrined\svgSanitize\Sanitizer;
use Exception;

/**
 * This should be a proper laravel facade 🥲
 */
class ImageService
{
    use EntityAware;

    /**
     */
    public static function handle(MiscModel|Map|Model|Entity $model, string $folder = '', string $field = 'image')
    {
        // Remove the old image
        if (request()->post('remove-' . $field) == '1') {
            self::cleanup($model, $field);
            return;
        }

        // No new image
        if (!request()->has($field) && !request()->filled($field . '_url')) {
            return;
        }

        try {
            $file = $path = $cleanSVG = null;
            $url = request()->filled($field . '_url');

            // Download the file locally to check it out
            if ($url) {
                $externalUrl = request()->input($field . '_url');
                $externalFile = basename($externalUrl);

                $tempImage = tempnam(sys_get_temp_dir(), $externalFile);
                copy($externalUrl, $tempImage);

                $file = $tempImage;
                // Clean up the file name because weird letters can confuse thumbor
                $cleanImageName = Str::slug(
                    Str::before(
                        Str::before($externalFile, '%3F'),
                        '?'
                    )
                );
                $cleanImageName = str_replace(['.', '/'], ['', ''], $cleanImageName);
                $path = "{$folder}/" . uniqid() . "_" . Str::limit($cleanImageName, 20, '');

                // Check if file is too big
                $copiedFileSize = ceil(filesize($tempImage) / 1000);
                if ($copiedFileSize > Limit::upload()) {
                    unlink($tempImage);
                    throw new \Exception('image_url target too big');
                }
                $file = new UploadedFile($tempImage, basename($externalUrl));

                // Add back the extension if it's missing after trimming long names
                $imageUrlExt = '.' . str_replace('image/', '', $file->getMimeType());
                if (!Str::endsWith($path, $imageUrlExt)) {
                    $path = $path . mb_strtolower($imageUrlExt);
                }
            } else {
                $file = request()->file($field);
                $path = $file->hashName($folder);
            }

            // Sanitize SVGs to avoid any XSS attacks
            if ($file->getMimeType() == 'image/svg+xml') {
                $sanitizer = new Sanitizer();

                // Custom allowed attributes for AFMG
                $allowedAttributes = new SvgAllowedAttributes();
                $sanitizer->setAllowedAttrs($allowedAttributes);

                $dirtySVG = file_get_contents($file);
                $cleanSVG = $sanitizer->sanitize($dirtySVG);
                file_put_contents($file, $cleanSVG);

                $xml = simplexml_load_string($cleanSVG);
                $sizes[0] = $xml->attributes()->width;
                $sizes[1] = $xml->attributes()->height;
            } else {
                $sizes = getimagesize($file->path());
            }

            if (!empty($path)) {
                // Remove old
                self::cleanup($model, $field);

                // Save new image
                if ($url) {
                    if ($file->getMimeType() == 'image/svg+xml') {
                        // GD can't handle svgs, so we need to move them directly
                        Storage::put($path, $cleanSVG, 'public');
                    } else {
                        $image = Image::make($file);
                        Storage::put($path, (string)$image->encode(), 'public');
                    }
                } else {
                    $path = request()->file($field)->storePublicly($folder);
                }
                if ($model instanceof Entity) {
                    $model->image_path = $path;
                } else {
                    $model->$field = $path;
                }

                if (!empty($sizes) && $model instanceof Entity && $model->isMap()) {
                    $model->map->width = $sizes[0];
                    $model->map->height = $sizes[1];
                    $model->map->saveQuietly();
                }
            }
        } catch (Exception $e) {
            //throw $e;
            // There was an error getting the image. Could be the url, could be the request.
            session()->flash('warning', trans('crud.image.error', ['size' => Limit::readable()->upload()]));
        }
    }

    /**
     */
    public static function entity(Entity $entity, string $folder = '', string $field = 'header_image')
    {
        if (request()->has($field) || request()->filled($field . '_url')) {
            try {
                $file = $path = null;
                $url = request()->filled($field . '_url');

                // Download the file locally to check it out
                if ($url) {
                    $externalUrl = request()->post($field . '_url');
                    $externalFile = basename($externalUrl);

                    $tempImage = tempnam(sys_get_temp_dir(), $externalFile);
                    copy($externalUrl, $tempImage);

                    $file = $tempImage;
                    $path = rtrim($folder, '/') . '/' . uniqid() . '_' . $externalFile;

                    // Check if file is too big
                    $copiedFileSize = ceil(filesize($tempImage) / 1000);
                    if ($copiedFileSize > Limit::upload()) {
                        unlink($tempImage);
                        throw new \Exception('image_url target too big');
                    }
                    $file = new UploadedFile($tempImage, basename($externalUrl));
                } else {
                    $file = request()->file($field);
                    $path = $file->hashName($folder);
                }

                // Sanitize SVGs to avoid any XSS attacks
                $cleanSVG = '';
                if ($file->getMimeType() == 'image/svg+xml') {
                    $sanitizer = new Sanitizer();
                    $dirtySVG = file_get_contents($file);
                    $cleanSVG = $sanitizer->sanitize($dirtySVG);
                    file_put_contents($file, $cleanSVG);
                }

                if (!empty($path)) {
                    // Remove old
                    self::cleanup($entity, $field);

                    // Save new image
                    if ($url) {
                        if ($file->getMimeType() == 'image/svg+xml') {
                            // GD can't handle svgs, so we need to move them directly
                            Storage::put($path, $cleanSVG, 'public');
                        } else {
                            $image = Image::make($file);
                            Storage::put($path, (string)$image->encode(), 'public');
                        }
                    } else {
                        $path = request()->file($field)->storePublicly($folder);
                    }
                    $entity->$field = $path;
                }
            } catch (Exception $e) {
                // There was an error getting the image. Could be the url, could be the request.
                session()->flash('warning', trans('crud.image.error', ['size' => Limit::readable()->upload()]));
            }
        } elseif (request()->post('remove-' . $field) == '1') {
            // Remove old
            self::cleanup($entity, $field);
        }
    }

    /**
     * Delete old image and thumb
     * @param MiscModel|Entity|Model $model
     */
    public static function cleanup($model, $field = 'image')
    {
        if ($model instanceof Entity && $field === 'image') {
            $field = 'image_path';
        }
        if (empty($model->$field)) {
            return;
        }

        try {
            Storage::delete($model->$field);
            // Leave removing thumbs for old campaigns
            $thumb = str_replace('.', '_thumb.', $model->$field);
            if (Storage::has($thumb)) {
                Storage::delete($thumb);
            }
        } catch (Exception $e) {
            // silence exception, didn't find the image to delete.
        }
        $model->$field = null;
    }
}
