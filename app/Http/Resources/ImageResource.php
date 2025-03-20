<?php

namespace App\Http\Resources;

use App\Facades\Img;
use App\Models\Image;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Image $image */
        $image = $this->resource;

        return [
            'id' => $image->id,
            'name' => $image->name,
            'is_folder' => (bool) $image->is_folder,
            'folder_id' => $image->folder_id,

            'path' => $image->is_folder ? null : Img::crop(300, 300)->url($image->path),

            'ext' => $image->ext,
            'size' => $image->size,

            'created_at' => $image->created_at,
            'created_by' => $image->created_by,
            'updated_at' => $image->updated_at,

            'visibility_id' => $image->visibility_id,

            'focus_x' => $image->focus_x,
            'focus_y' => $image->focus_y,

        ];
    }
}
