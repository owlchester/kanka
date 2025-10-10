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
        $this->translations();
        $this->urls();
        $this->fixData();

        return $this->data;
    }

    protected function loadImages(): void
    {
        $this->data['images'] = [];

        $galleryIds = $entityIds = [];
        foreach ($this->data['data'] as $shape) {
            if ($shape['type'] === 'image') {
                $galleryIds[] = $shape['uuid'];
            } elseif ($shape['type'] === 'entity') {
                $entityIds[] = $shape['entity'];
            }
        }

        $this
            ->loadEntities($entityIds)
            ->loadGallery($galleryIds);
    }

    protected function translations(): void
    {
        $this->data['i18n'] = [
            'close' => __('crud.actions.close'),
            'save' => __('crud.save'),
            'delete' => __('crud.permissions.actions.delete'),
            'add-square' => __('whiteboards/draw.actions.add-square'),
            'add-circle' => __('whiteboards/draw.actions.add-circle'),
            'add-entity' => __('whiteboards/draw.actions.add-entity'),
            'add-image' => __('whiteboards/draw.actions.add-image'),
            'start-drawing' => __('whiteboards/draw.actions.start-drawing'),
            'end-drawing' => __('whiteboards/draw.actions.end-drawing'),
            'color' => __('whiteboards/draw.fields.color'),
            'thin-stroke' => __('whiteboards/draw.pen.thin-stroke'),
            'large-stroke' => __('whiteboards/draw.pen.large-stroke'),
            'push-to-front' => __('whiteboards/draw.actions.push-to-front'),
            'push-to-back' => __('whiteboards/draw.actions.push-to-back'),
            'lock' => __('whiteboards/draw.actions.lock'),
            'unlock' => __('whiteboards/draw.actions.unlock'),

            // General UI
            'back' => __('whiteboards/draw.actions.back'),

            // Entity search
            'entity-search' => __('whiteboards/draw.entity-search.title'),
            'search-placeholder' => __('whiteboards/draw.entity-search.placeholder'),

            // Browse stuff
            'cancel' => __('crud.cancel'),
            'remove' => __('crud.remove'),
            'url' => __('gallery.actions.url'),
            'gallery' => __('gallery.actions.gallery'),
            'unauthorized' => __('gallery.download.errors.unauthorized'),
            'browse' => [
                'title' => __('gallery.browse.title'),
                'layouts' => [
                    'small' => __('gallery.browse.layouts.small'),
                    'large' => __('gallery.browse.layouts.large'),
                ],
                'search' => [
                    'placeholder' => __('gallery.browse.search.placeholder'),
                ],
                'unauthorized' => __('gallery.browse.unauthorized'),
            ],
            'cta_title' => __('gallery.cta.title'),
            'cta_action' => __('gallery.cta.action'),
            'cta_helper' => __('gallery.cta.helper', [
                'premium-campaign' => '<a href="https://kanka.io/premium" target="_blank">' . __('concept.premium-campaign') . '</a>',
                'size' => number_format(config('limits.gallery.premium') / (1024 * 1024), 2),
            ]),

        ];
    }

    protected function loadEntities(array $ids): self
    {
        $entities = Entity::select('id', 'image_path', 'image_uuid', 'type_id')
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

    protected function fixData(): void
    {
        foreach ($this->data['data'] as $id => $shape) {
            if (! isset($shape['scaleX'])) {
                $shape['scaleX'] = 1;
            }
            if (! isset($shape['scaleY'])) {
                $shape['scaleY'] = 1;
            }
            $this->data['data'][$id] = $shape;
        }
    }

    protected function urls(): void
    {
        $this->data['urls'] = [
            'overview' => route('entities.show', [$this->campaign, $this->whiteboard->entity]),
        ];
    }
}
