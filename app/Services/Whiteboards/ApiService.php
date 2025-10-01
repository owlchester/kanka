<?php

namespace App\Services\Whiteboards;

use App\Facades\Avatar;
use App\Models\Entity;
use App\Models\Image;
use App\Models\Whiteboard;
use App\Traits\CampaignAware;

class ApiService
{
    use CampaignAware;

    protected Whiteboard $whiteboard;

    protected array $data = [];

    public function whiteboard(Whiteboard $whiteboard): self
    {
        $this->whiteboard = $whiteboard;

        return $this;
    }

    public function load(): array
    {
        $this->data['name'] = $this->whiteboard->name;
        $this->data['data'] = $this->whiteboard->data ?? [];
        $this->loadImages();

        return $this->data;
    }

    protected function loadImages(): void
    {
        $this->data['images'] = [];

        $galleryIds = $entityIds = [];
        foreach ($this->data['data'] as $shape) {
            if ($shape['type'] === 'gallery') {
                $galleryIds[] = $shape['id'];
            } elseif ($shape['type'] === 'entity') {
                $entityIds[] = $shape['entity'];
            }
        }

        $this
            ->loadEntities($entityIds)
            ->loadGallery($galleryIds);
    }

    protected function loadEntities(array $ids): self
    {
        $entities = Entity::select('id', 'image_path', 'image_uuid')
            ->with(['image', 'entityType'])
            ->whereIn('id', $ids)
            ->get();
        foreach ($entities as $entity) {
            $this->data['images'][$entity->id] = Avatar::entity($entity)->size(256)->fallback()->thumbnail();
        }
        return $this;
    }
    protected function loadGallery(array $ids): self
    {
        /** @var Image[] $images */
        $images = Image::whereIn('id', $ids)
            ->get();
        foreach ($images as $image) {
            $this->data['images'][$image->id] = $image->url();
        }
        return $this;
    }
}
