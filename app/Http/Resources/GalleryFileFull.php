<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryFileFull extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Image $file */
        $file = $this->resource;

        $file->loadMissing([
            'entities',
            'headers',
            'entityAssets.entity',
            'mentions.entity',
            'mentions.post',
            'mapLayers.map.entity',
            'inventories.entity',
        ]);

        $mentions = [];
        $entityImages = [];
        $entityHeaders = [];
        $entryMentions = [];
        $mapLayers = [];
        $entityAssets = [];
        $inventories = [];

        foreach ($file->entities as $entity) {
            $item = [
                'url' => $entity->url(),
                'name' => $entity->name,
                'type' => 'image',
            ];
            $entityImages[] = $item;
            $mentions[] = $item;
        }

        foreach ($file->headers as $entity) {
            $item = [
                'url' => $entity->url(),
                'name' => $entity->name,
                'type' => 'header',
            ];
            $entityHeaders[] = $item;
            $mentions[] = [
                'url' => $entity->url(),
                'name' => $entity->name,
                'type' => 'image',
            ];
        }

        foreach ($file->entityAssets as $asset) {
            if (! $asset->entity) {
                continue;
            }
            $entityAssets[] = [
                'url' => $asset->entity->url(),
                'name' => $asset->name ?: $asset->entity->name,
                'entity_name' => $asset->entity->name,
                'type' => 'asset',
            ];
            $mentions[] = [
                'url' => $asset->entity->url(),
                'name' => $asset->entity->name,
                'type' => 'image',
            ];
        }

        foreach ($file->mentions as $mention) {
            if ($mention->isPost() && $mention->post && $mention->entity) {
                $item = [
                    'url' => $mention->entity->url() . '?#post-' . $mention->post_id,
                    'name' => $mention->post->name,
                    'entity_name' => $mention->entity->name,
                    'type' => 'post',
                ];
                $entryMentions[] = $item;
                $mentions[] = $item;
            } elseif ($mention->entity) {
                $item = [
                    'url' => $mention->entity->url(),
                    'name' => $mention->entity->name,
                    'type' => 'entity',
                ];
                $entryMentions[] = $item;
                $mentions[] = $item;
            }
        }

        foreach ($file->mapLayers as $layer) {
            if (! $layer->map?->entity) {
                continue;
            }
            $mapLayers[] = [
                'url' => $layer->map->entity->url(),
                'name' => $layer->map->entity->name . ' (' . $layer->name . ')',
                'type' => 'map_layer',
            ];
        }

        foreach ($file->inventories as $inventory) {
            if (! $inventory->entity) {
                continue;
            }
            $inventories[] = [
                'url' => $inventory->entity->url(),
                'name' => $inventory->name . ' (' . $inventory->entity->name . ')',
                'type' => 'inventory',
            ];
        }

        return [
            'mentions' => $mentions,
            'usages' => [
                'entity_images' => $entityImages,
                'entity_headers' => $entityHeaders,
                'entry_mentions' => $entryMentions,
                'map_layers' => $mapLayers,
                'entity_assets' => $entityAssets,
                'inventories' => $inventories,
                'is_default' => (bool) $file->is_default,
            ],
        ];
    }
}
