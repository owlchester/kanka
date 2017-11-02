<?php

namespace App\Services;

use App\MiscModel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    /**
     * @param MiscModel $model
     * @param string $folder
     */
    public static function handle(MiscModel $model, $folder = '', $thumbSize = 60)
    {
        if (request()->has('image')) {
            $file = request()->file('image');
            $path = $file->hashName($folder);

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
                $path = request()->file('image')->store($folder, 'public');

                $model->image = $path;
            }
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
        }
    }
}
