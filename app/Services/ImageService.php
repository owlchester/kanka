<?php

namespace App\Services;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Sanitizers\SvgAllowedAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use enshrined\svgSanitize\Sanitizer;
use Exception;

class ImageService
{
    /**
     * @param MiscModel $model
     * @param string $folder
     */
    public static function handle(Model $model, string $folder = '', $thumbSize = 60, $field = 'image')
    {
        // Remove the old image
        if (request()->post('remove-' . $field) == '1') {
            self::cleanup($model, $field);
            return;
        }

        // No new image
        if (!request()->has($field) and !request()->filled($field . '_url')) {
            return;
        }

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
                $path = "$folder/" . uniqid() . "_" . Str::before(Str::before($externalFile, '%3F'), '?');

                // Check if file is too big
                $copiedFileSize = ceil(filesize($tempImage) / 1000);
                if ($copiedFileSize > auth()->user()->maxUploadSize()) {
                    unlink($tempImage);
                    throw new \Exception('image_url target too big');
                }
                $file = new UploadedFile($tempImage, basename($externalUrl));
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

                // Create a thumb of the picture
//                    if ($thumbSize !== false) {
//                        $image = Image::make($file)->resize($thumbSize, null, function ($constraint) {
//                            $constraint->aspectRatio();
//                        });
//                        Storage::put($thumb, (string) $image->encode(), 'public');
//                    }

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
                $model->$field = $path;

                if (!empty($sizes) && array_key_exists('height', $model->getAttributes())) {
                    $model->width = $sizes[0];
                    $model->height = $sizes[1];
                }
            }
        } catch (Exception $e) {
            //throw $e;
            // There was an error getting the image. Could be the url, could be the request.
            session()->flash('warning', trans('crud.image.error', ['size' => auth()->user()->maxUploadSize(true)]));
        }
    }

    /**
     * @param Entity $entity
     * @param string $folder
     * @param int $thumbSize
     * @param string $field
     */
    public static function entity(Entity $entity, string $folder = '', $thumbSize = 60, string $field = 'header_image')
    {
        if (request()->has($field) or request()->filled($field . '_url')) {
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
                    if ($copiedFileSize > auth()->user()->maxUploadSize()) {
                        unlink($tempImage);
                        throw new \Exception('image_url target too big');
                    }
                    $file = new UploadedFile($tempImage, basename($externalUrl));
                } else {
                    $file = request()->file($field);
                    $path = $file->hashName($folder);
                }

                // Sanitize SVGs to avoid any XSS attacks
                if ($file->getMimeType() == 'image/svg+xml') {
                    $sanitizer = new Sanitizer();
                    $dirtySVG = file_get_contents($file);
                    $cleanSVG = $sanitizer->sanitize($dirtySVG);
                    file_put_contents($file, $cleanSVG);
                }

                if (!empty($path)) {
                    // Remove old
                    self::cleanup($entity, $field);

//                    // Create a thumb of the picture
//                    if ($thumbSize !== false) {
//                        $image = Image::make($file)->resize($thumbSize, null, function ($constraint) {
//                            $constraint->aspectRatio();
//                        });
//                        Storage::put($thumb, (string) $image->encode(), 'public');
//                    }

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
                session()->flash('warning', trans('crud.image.error', ['size' => auth()->user()->maxUploadSize(true)]));
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
        if ($model->$field) {
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
}
