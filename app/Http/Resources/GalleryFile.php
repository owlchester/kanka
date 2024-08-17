<?php

namespace App\Http\Resources;

use App\Models\Image;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryFile extends JsonResource
{
    use CampaignAware;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Image $file */
        $file = $this->resource;
        return [
            'id' => $file->id,
            'is_folder' => $file->isFolder(),
            'name' => $file->name,
            'thumbnail' => $file->hasThumbnail() ? $file->getUrl(192, 144) : null,
            'thumbnails' => $file->isFolder() ? $this->thumbnails($file) : null,
            'visibility' => $file->visibilityIcon(true),
            'visibility_id' => $file->visibility_id,
            'is_selected' => false,
            'is_deleted' => false,
            'open' => route('gallery.show', [$this->campaign, $file]),
            'ext' => $file->ext,
            'size' => $file->niceSize(),
            'creator' => $file->creator->name ?? __('crud.unknown')
        ];
    }


    protected function thumbnails(Image $file): array
    {
        $thumbnails = [];
        foreach ($file->images as $subFile) {
            if (count($thumbnails) >= 3) {
                return $thumbnails;
            }
            if ($subFile->isFolder()) {
                continue;
            }
            $thumbnails[] = $subFile->getUrl(192, 144);
        }

        return $thumbnails;
    }
}
