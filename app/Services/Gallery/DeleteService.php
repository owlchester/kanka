<?php

namespace App\Services\Gallery;

use App\Models\Image;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;

class DeleteService
{
    use CampaignAware;
    use UserAware;

    public function delete(array $ids): int
    {
        $images = Image::where('campaign_id', $this->campaign->id)
            ->whereIn('id', $ids)
            ->get();

        foreach ($images as $image) {
            if ($this->user && ! $this->user->can('delete', [$image, $this->campaign])) {
                abort(403);
            }
        }

        // Loop individually so ImageObserver runs for each model and recursively cleans folders/files
        $count = 0;
        foreach ($images as $image) {
            $image->delete();
            $count++;
        }

        return $count;
    }

    /**
     * Build a structured impact preview for deleting the given image/folder IDs.
     *
     * @return array<string, mixed>
     */
    public function preview(array $ids): array
    {
        $roots = Image::where('campaign_id', $this->campaign->id)
            ->whereIn('id', $ids)
            ->get();

        foreach ($roots as $image) {
            if ($this->user && ! $this->user->can('delete', [$image, $this->campaign])) {
                abort(403);
            }
        }

        $expanded = $this->expandSelection($roots);
        $files = $expanded->where('is_folder', false)->values();
        $folders = $expanded->where('is_folder', true)->values();

        if ($files->isNotEmpty()) {
            $files = Image::whereIn('id', $files->pluck('id'))
                ->with([
                    'entities',
                    'headers',
                    'entityAssets.entity',
                    'mentions.entity',
                    'mentions.post',
                    'mapLayers.map.entity',
                    'inventories.entity',
                ])
                ->get();
        }

        $entryMentions = [];
        $entityImages = [];
        $entityHeaders = [];
        $mapLayers = [];
        $entityAssets = [];
        $inventories = [];
        $defaultImages = [];

        foreach ($files as $file) {
            /** @var Image $file */
            if ($file->is_default) {
                $defaultImages[] = [
                    'image_id' => $file->id,
                    'image_name' => $file->name,
                ];
            }

            foreach ($file->entities as $entity) {
                $entityImages[] = [
                    'name' => $entity->name,
                    'url' => $entity->url(),
                    'image_name' => $file->name,
                ];
            }

            foreach ($file->headers as $entity) {
                $entityHeaders[] = [
                    'name' => $entity->name,
                    'url' => $entity->url(),
                    'image_name' => $file->name,
                ];
            }

            foreach ($file->entityAssets as $asset) {
                if (! $asset->entity) {
                    continue;
                }
                $entityAssets[] = [
                    'name' => $asset->name ?: $asset->entity->name,
                    'entity_name' => $asset->entity->name,
                    'url' => $asset->entity->url(),
                    'image_name' => $file->name,
                ];
            }

            foreach ($file->mentions as $mention) {
                if ($mention->isPost() && $mention->post && $mention->entity) {
                    $entryMentions[] = [
                        'name' => $mention->entity->name . ' — ' . $mention->post->name,
                        'entity_name' => $mention->entity->name,
                        'post_name' => $mention->post->name,
                        'url' => $mention->entity->url() . '?#post-' . $mention->post_id,
                        'image_name' => $file->name,
                        'type' => 'post',
                    ];
                } elseif ($mention->entity) {
                    $entryMentions[] = [
                        'name' => $mention->entity->name,
                        'entity_name' => $mention->entity->name,
                        'url' => $mention->entity->url(),
                        'image_name' => $file->name,
                        'type' => 'entry',
                    ];
                }
            }

            foreach ($file->mapLayers as $layer) {
                if (! $layer->map?->entity) {
                    continue;
                }
                $mapLayers[] = [
                    'name' => $layer->map->entity->name . ' (' . $layer->name . ')',
                    'url' => $layer->map->entity->url(),
                    'image_name' => $file->name,
                ];
            }

            foreach ($file->inventories as $inventory) {
                if (! $inventory->entity) {
                    continue;
                }
                $inventories[] = [
                    'name' => $inventory->name . ' (' . $inventory->entity->name . ')',
                    'url' => $inventory->entity->url(),
                    'image_name' => $file->name,
                ];
            }
        }

        $totalKb = (int) $files->sum('size');
        $hasImpacts = ! empty($entryMentions)
            || ! empty($entityImages)
            || ! empty($entityHeaders)
            || ! empty($mapLayers)
            || ! empty($entityAssets)
            || ! empty($inventories)
            || ! empty($defaultImages);

        return [
            'total_files' => $files->count(),
            'total_folders' => $folders->count(),
            'total_size_kb' => $totalKb,
            'total_size_readable' => $this->formatSize($totalKb),
            'has_entry_mentions' => ! empty($entryMentions),
            'has_impacts' => $hasImpacts,
            'impacts' => [
                'entry_mentions' => $entryMentions,
                'entity_images' => $entityImages,
                'entity_headers' => $entityHeaders,
                'map_layers' => $mapLayers,
                'entity_assets' => $entityAssets,
                'inventories' => $inventories,
                'default_images' => $defaultImages,
            ],
        ];
    }

    /**
     * Recursively expand selected folders into all contained files and subfolders.
     *
     * @param  Collection<int, Image>  $roots
     * @return Collection<int, Image>
     */
    protected function expandSelection(Collection $roots): Collection
    {
        $collected = $roots->keyBy('id');
        $frontier = $roots->where('is_folder', true)->pluck('id')->all();
        $depth = 0;

        while (! empty($frontier) && $depth < 50) {
            $children = Image::where('campaign_id', $this->campaign->id)
                ->whereIn('folder_id', $frontier)
                ->get();

            $nextFrontier = [];
            foreach ($children as $child) {
                if ($collected->has($child->id)) {
                    continue;
                }
                $collected->put($child->id, $child);
                if ($child->is_folder) {
                    $nextFrontier[] = $child->id;
                }
            }
            $frontier = $nextFrontier;
            $depth++;
        }

        return $collected->values();
    }

    protected function formatSize(int $kb): string
    {
        if ($kb >= 1024 * 1024) {
            return round($kb / (1024 * 1024), 2) . ' GiB';
        }
        if ($kb >= 1024) {
            return round($kb / 1024, 2) . ' MiB';
        }

        return $kb . ' KiB';
    }
}
