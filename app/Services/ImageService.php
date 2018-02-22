<?php

namespace App\Services;

use App\Models\MiscModel;
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
    public static function handle(MiscModel $model, $folder = '', $thumbSize = 60)
    {
        if (request()->has('image') or request()->filled('image_url')) {

            try {
                $file = $path = null;
                $url = request()->filled('image_url');

                // Download the file locally to check it out
                if ($url) {
                    $externalUrl = request()->post('image_url');
                    $externalFile = basename($externalUrl);

                    $tempImage = tempnam(sys_get_temp_dir(), $externalFile);
                    copy($externalUrl, $tempImage);

                    $file = $tempImage;
                    $path = "$folder/" . $model->id . "_" . $externalFile;
                } else {
                    $file = request()->file('image');
                    $path = $file->hashName($folder);
                }

                $thumb = '/public/' . str_replace('.', '_thumb.', $path);

                if (!empty($path)) {
                    // Remove old
                    self::cleanup($model);

                    // Create a thumb of the picture
                    if ($thumbSize !== false) {
                        $image = Image::make($file)->resize($thumbSize, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        Storage::put($thumb, $image->encode());
                    }

                    // Save new image
                    if ($url) {
                        $image = Image::make($file);
                        Storage::put('/public/' . $path, $image->encode());
                    } else {
                        $path = request()->file('image')->store($folder, 'public');
                    }

                    $model->image = $path;
                }
            } catch (Exception $e) {
                // There was an error getting the image. Could be the url, could be the request.
                session()->flash('warning', trans('crud.image.error'));
            }
        } elseif (request()->post('remove-image') == '1') {
            // Remove old
            self::cleanup($model);
        }
    }

    /**
     * Delete old image and thumb
     * @param MiscModel $model
     */
    public static function cleanup(MiscModel $model)
    {
        if ($model->image) {
            Storage::disk('public')->delete($model->image);
            $thumb = str_replace('.', '_thumb.', $model->image);
            if (Storage::disk('public')->has($thumb)) {
                Storage::disk('public')->delete($thumb);
            }
            $model->image = null;
        }
    }
}
