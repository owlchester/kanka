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
            "id" => $file->id,
            "is_folder" => $file->isFolder(),
            "name" => $file->name,
            "thumbnail" => $file->hasThumbnail()
                ? $file->getUrl(192, 144)
                : null,
            "original" => $file->hasThumbnail() ? $file->url() : null,
            "thumbnails" => $file->isFolder() ? $this->thumbnails($file) : null,
            "visibility_id" => $file->visibility_id,
            "focus_x" => $file->focus_x,
            "focus_y" => $file->focus_y,
            "is_selected" => false,
            "is_deleted" => false,
            "open" => route("gallery.show", [$this->campaign, $file]),
            "link" => $file->url(),
            "ext" => $file->ext,
            "size" => $file->niceSize(),
            "creator" => $file->creator->name ?? __("crud.unknown"),
            "api" => [
                "show" => route("gallery.file.show", [$this->campaign, $file]),
                "update" => route("gallery.file.update", [
                    $this->campaign,
                    $file,
                ]),
                "delete" => route("gallery.file.delete", [
                    $this->campaign,
                    $file,
                ]),
                "focus" => route("gallery.file.update-focus", [
                    $this->campaign,
                    $file,
                ]),
            ],
        ];
    }

    protected function thumbnails(Image $file): array
    {
        $thumbnails = [];
        foreach ($file->images as $subFile) {
            if (!$subFile->hasThumbnail()) {
                continue;
            }
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
