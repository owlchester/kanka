<?php

namespace App\Http\Resources\Gallery\Tiptap;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Image $image */
        $image = $this->resource;

        return [
            'src' => $image->url(),
            'name' => $image->name,
            'folder' => $image->isFolder(),
            'uuid' => $image->id,
            'icon' => 'fa-regular fa-folder',
            'url' => $image->isFolder() ? route('gallery.tiptap', [$image->campaign, 'folder' => $image->id]) : null,
            'thumbnail' => $image->getUrl(192, 144),
        ];
    }
}
