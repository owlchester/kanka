<?php

namespace App\Http\Resources;

use App\Models\Image;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryFile extends JsonResource
{
    use CampaignAware;

    /** @var array<int, string>|null */
    protected ?array $prefetchedThumbnails = null;

    /**
     * @param  array<int, string>  $thumbnails
     */
    public function withThumbnails(array $thumbnails): self
    {
        $this->prefetchedThumbnails = $thumbnails;

        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Image $file */
        $file = $this->resource;

        $isFolder = $file->isFolder();
        $hasPreview = $file->hasThumbnail() || $file->isSvg();

        $usageCount = null;
        if (! $isFolder) {
            if (isset($file->entities_count)) {
                $usageCount = (int) $file->entities_count
                    + (int) ($file->headers_count ?? 0)
                    + (int) ($file->mentions_count ?? 0)
                    + (int) ($file->entity_assets_count ?? 0)
                    + (int) ($file->map_layers_count ?? 0)
                    + (int) ($file->inventories_count ?? 0)
                    + ($file->is_default ? 1 : 0);
            }
        }

        $itemsCount = $isFolder && isset($file->images_count)
            ? (int) $file->images_count
            : null;

        return [
            'id' => $file->id,
            'folder_id' => $file->folder_id,
            'is_folder' => $isFolder,
            'is_font' => $file->isFont(),
            'is_svg' => $file->isSvg(),
            'is_default' => (bool) $file->is_default,
            'name' => $file->name,
            'description' => $file->description,
            'author' => $file->author,
            'thumbnail' => $file->hasThumbnail()
                ? $file->getUrl(192, 144)
                : ($file->isSvg() ? $file->url() : null),
            'original' => $hasPreview ? $file->url() : null,
            'thumbnails' => $isFolder ? ($this->prefetchedThumbnails ?? $this->thumbnails($file)) : null,
            'visibility_id' => $file->visibility_id->value,
            'focus_x' => $file->focus_x,
            'focus_y' => $file->focus_y,
            'is_selected' => false,
            'is_deleted' => false,
            'open' => route('gallery.show', [$this->campaign, $file]),
            'link' => $file->url(),
            'admin_url' => route('gallery', array_filter([
                $this->campaign,
                'folder' => $file->folder_id,
                'image' => $isFolder ? null : $file->id,
            ])),
            'ext' => $file->ext,
            'size' => $file->niceSize(),
            'size_kb' => (int) ($file->size ?? 0),
            'width' => $file->width(),
            'height' => $file->height(),
            'items_count' => $itemsCount,
            'usage_count' => $usageCount,
            'creator_id' => $file->created_by,
            'creator' => $file->creator->name ?? __('crud.users.unknown'),
            'created_at' => $file->created_at?->toIso8601String(),
            'created_at_human' => $file->created_at?->diffForHumans(),
            'updated_at' => $file->updated_at?->toIso8601String(),
            'updated_at_human' => $file->updated_at?->diffForHumans(),
            'can_edit' => $request->user()?->can('edit', [$file, $this->campaign]) ?? false,
            'api' => [
                'show' => route('gallery.file.show', [$this->campaign, $file]),
                'update' => route('gallery.file.update', [
                    $this->campaign,
                    $file,
                ]),
                'delete' => route('gallery.file.delete', [
                    $this->campaign,
                    $file,
                ]),
                'focus' => route('gallery.file.update-focus', [
                    $this->campaign,
                    $file,
                ]),
                'replace' => route('gallery.file.replace', [
                    $this->campaign,
                    $file,
                ]),
            ],
        ];
    }

    protected function thumbnails(Image $file): array
    {
        if (! $file->relationLoaded('images')) {
            return [];
        }

        $thumbnails = [];
        foreach ($file->images as $subFile) {
            if (! $subFile->hasThumbnail() || $subFile->isFolder()) {
                continue;
            }
            $thumbnails[] = $subFile->getUrl(192, 144);
            if (count($thumbnails) >= 3) {
                return $thumbnails;
            }
        }

        return $thumbnails;
    }
}
