<?php

namespace App\Services\Gallery;

use App\Models\Image;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class BrowseService
{
    use CampaignAware;
    use UserAware;

    protected ?string $folder = null;

    protected ?string $term = null;

    protected string $sort = 'recent';

    public function term(?string $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function folder(?string $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    public function sort(?string $sort): self
    {
        if (in_array($sort, ['recent', 'name_asc', 'name_desc'], true)) {
            $this->sort = $sort;
        }

        return $this;
    }

    public function images(): array
    {
        $results = [
            'images' => [],
            'breadcrumbs' => [],
        ];

        $canBrowse = $this->user->can('galleryBrowse', $this->campaign);

        $currentFolder = null;
        if (! empty($this->folder)) {
            $currentFolder = Image::where('campaign_id', $this->campaign->id)
                ->where('is_folder', true)
                ->where('id', $this->folder)
                ->firstOrFail();

            $results['breadcrumbs'] = $this->breadcrumbs($currentFolder);

            if (request()->integer('page', 1) === 1) {
                $results['images'][] = [
                    'name' => __('crud.actions.back'),
                    'folder' => true,
                    'icon' => 'fa-regular fa-arrow-left',
                    'url' => route('gallery.browse', [$this->campaign, 'folder' => $currentFolder->folder_id]),
                    'image_count' => null,
                ];
            }
        }

        $query = Image::where('campaign_id', $this->campaign->id)
            ->acl($canBrowse)
            ->search($this->folder, $this->term)
            ->where('is_default', false)
            ->withoutFonts()
            ->withCount(['images as images_count' => fn ($q) => $q->where('is_folder', false)->where('is_default', false)->withoutFonts()])
            ->orderBy('is_folder', 'desc');

        match ($this->sort) {
            'name_asc' => $query->orderBy('name', 'asc')->orderBy('updated_at', 'desc'),
            'name_desc' => $query->orderBy('name', 'desc')->orderBy('updated_at', 'desc'),
            default => $query->orderBy('updated_at', 'desc'),
        };

        $images = $query->paginate(40);
        $results['next'] = $images->nextPageUrl();
        $results['pagination'] = [
            'current_page' => $images->currentPage(),
            'last_page' => $images->lastPage(),
            'prev' => $images->previousPageUrl(),
            'next' => $images->nextPageUrl(),
            'total' => $images->total(),
        ];

        /** @var Image $image */
        foreach ($images as $image) {
            $results['images'][] = [
                'src' => $image->url(),
                'name' => $image->name,
                'description' => $image->description,
                'folder' => $image->isFolder(),
                'uuid' => $image->id,
                'icon' => 'fa-regular fa-folder',
                'url' => $image->isFolder() ? route('gallery.browse', [$this->campaign, 'folder' => $image->id]) : null,
                'thumbnail' => $image->getUrl(192, 144),
                'selection_thumbnail' => $image->getUrl(160, 160),
                'ext' => $image->isFolder() ? null : strtoupper((string) $image->ext),
                'size' => $image->isFolder() ? null : $image->niceSize(),
                'image_count' => $image->isFolder() ? $image->images_count : null,
            ];
        }

        return $results;
    }

    /**
     * @return array<int, array{id: string, name: string, url: string}>
     */
    protected function breadcrumbs(Image $folder): array
    {
        $crumbs = [];
        $visited = [];
        $current = $folder;
        $depth = 0;

        while ($current && $depth < 50) {
            if (isset($visited[$current->id])) {
                break;
            }
            $visited[$current->id] = true;
            array_unshift($crumbs, [
                'id' => $current->id,
                'name' => $current->name,
                'url' => route('gallery.browse', [$this->campaign, 'folder' => $current->id]),
            ]);
            $current = $current->imageFolder;
            $depth++;
        }

        return $crumbs;
    }
}
