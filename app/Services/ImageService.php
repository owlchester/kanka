<?php

namespace App\Services;

use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
use Exception;

class ImageService
{
    /**
     * @param MiscModel $model
     * @param string $folder
     */
    public static function handle(Model $model, $folder = '', $thumbSize = 60, $field = 'image')
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
                    $path = "$folder/" . uniqid() . "_" . $externalFile;
                } else {
                    $file = request()->file($field);
                    $path = $file->hashName($folder);
                }

                $thumb = str_replace('.', '_thumb.', $path);

                if (!empty($path)) {
                    // Remove old
                    self::cleanup($model, $field);

                    // Create a thumb of the picture
                    if ($thumbSize !== false) {
                        $image = Image::make($file)->resize($thumbSize, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        Storage::put($thumb, (string) $image->encode(), 'public');
                    }

                    // Save new image
                    if ($url) {
                        $image = Image::make($file);
                        Storage::put($path, (string) $image->encode(), 'public');
                    } else {
                        $path = request()->file($field)->storePublicly($folder);
                    }
                    $model->$field = $path;
                }
            } catch (Exception $e) {
                // There was an error getting the image. Could be the url, could be the request.
                session()->flash('warning', trans('crud.image.error'));
            }
        } elseif (request()->post('remove-' . $field) == '1') {
            // Remove old
            self::cleanup($model, $field);
        }
    }

    /**
     * Delete old image and thumb
     * @param MiscModel $model
     */
    public static function cleanup(Model $model, $field = 'image')
    {
        if ($model->$field) {
            Storage::delete($model->$field);
            $thumb = str_replace('.', '_thumb.', $model->$field);
            if (Storage::has($thumb)) {
                Storage::delete($thumb);
            }
            $model->$field = null;
        }
    }
}
