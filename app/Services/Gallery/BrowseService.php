<?php

namespace App\Services\Gallery;

use App\Models\Image;
use App\Traits\CampaignAware;

class BrowseService
{
    use CampaignAware;

    protected null|string $folder;

    protected null|string $term;

    public function term(null|string $term): self
    {
        $this->term = $term;
        return $this;
    }
    public function folder(null|string $folder): self
    {
        $this->folder = $folder;
        return $this;
    }

    public function images(): array
    {
        $results = [];

        $canBrowse = auth()->user()->can('galleryBrowse', $this->campaign);

        if (!empty($this->folder)) {
            $image = Image::where('is_folder', true)->where('id', $this->folder)->firstOrFail();
            $results['images'][] = [
                'name' => __('crud.actions.back'),
                'folder' => true,
                'icon' => 'fa-regular fa-arrow-left',
                'url' => route('gallery.browse', [$this->campaign, 'folder' => $image->folder_id])
            ];
        }

        $images = Image::acl($canBrowse)
            ->search($this->folder, $this->term)
            ->where('is_default', false)
            ->orderBy('is_folder', 'desc')
            ->orderBy('updated_at', 'desc')
            ->offset(0)
            ->take(50)
            ->get();
        /** @var Image $image */
        foreach ($images as $image) {
            $results['images'][] = [
                'src' => $image->url(),
                'name' => $image->name,
                'folder' => $image->isFolder(),
                'uuid' => $image->id,
                'icon' => 'fa-regular fa-folder',
                'url' => $image->isFolder() ? route('gallery.browse', [$this->campaign, 'folder' => $image->id]) : null,
                'thumbnail' => $image->getUrl(192, 144),
            ];
        }

        return $results;
    }
}
