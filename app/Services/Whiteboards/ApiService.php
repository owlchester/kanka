<?php

namespace App\Services\Whiteboards;

use App\Facades\Avatar;
use App\Http\Resources\Whiteboards\ShapeResource;
use App\Models\Entity;
use App\Models\Image;
use App\Models\Whiteboard;
use App\Models\WhiteboardShape;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ApiService
{
    use CampaignAware;
    use UserAware;

    protected Whiteboard $whiteboard;

    protected array $data = [];
    protected array $images = [];
    protected array $entityIds = [];

    public function whiteboard(Whiteboard $whiteboard): self
    {
        $this->whiteboard = $whiteboard;

        return $this;
    }

    public function load(): array
    {
        $this->data['name'] = $this->whiteboard->name;
        $this->loadShapes();
        $this->loadEntities();
        $this->loadImages();
        $this->translations();
        $this->urls();
        $this->interactive();
        $this->fixData();

        return $this->data;
    }

    protected function loadShapes(): self
    {
        $this->data['data'] = $this->whiteboard->data ?? [];

        /** @var WhiteboardShape[]|Collection $shapes */
        $shapes = $this->whiteboard->shapes()->with(['whiteboard', 'whiteboard.campaign'])->get();
        $this->data['data'] = ShapeResource::collection($shapes);

        // Collect image UUIDs from image shapes
        foreach ($shapes as $shape) {
            if ($shape->isImage()) {
                $uuid = Arr::get($shape->shape, 'uuid');
                if ($uuid) {
                    $this->images[] = $uuid;
                }
            } elseif ($shape->isEntity()) {
                $entity = Arr::get($shape->shape, 'entity_id');
                if ($entity) {
                    $this->entityIds[] = $entity;
                }
            }
        }

        return $this;
    }

    protected function loadImages(): void
    {
        $this
            ->loadGallery();
    }

    protected function translations(): void
    {
        $this->data['i18n'] = [
            'close' => __('crud.actions.close'),
            'save' => __('crud.save'),
            'create' => __('crud.create'),
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
            'duplicate' => __('whiteboards/draw.actions.duplicate'),
            'copy-success' => __('whiteboards/draw.toast.copy.success'),
            'paste-error' => __('whiteboards/draw.toast.paste.error'),

            // Reset
            'reset-helper' => __('whiteboards/draw.reset.helper'),
            'reset' => __('crud.actions.reset'),
            'reset-title' => __('whiteboards/draw.reset.title'),

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
                'premium-campaign' => '<a href="https://kanka.io/premium" class="text-link">' . __('concept.premium-campaign') . '</a>',
                'size' => number_format(config('limits.gallery.premium') / (1024 * 1024), 2),
            ]),
            'qq-keyboard-shortcut' => __('crud.keyboard-shortcut', ['code' => '<code>N</code>']),

        ];
    }

    protected function loadEntities(): self
    {
        $entities = Entity::select('id', 'name', 'image_path', 'image_uuid', 'type_id')
            ->with(['image', 'entityType'])
            ->whereIn('id', $this->entityIds)
            ->get();
        /** @var Entity $entity */
        foreach ($entities as $entity) {
            $this->data['entities'][$entity->id] = [
                'id' => $entity->id,
                'name' => $entity->name,
                'link' => $entity->url(),
                'preview' => route('entities.tooltip', [$this->campaign, $entity]),
            ];
            $this->data['images'][$entity->id] = Avatar::entity($entity)->size(256)->fallback()->thumbnail();
        }

        return $this;
    }

    protected function loadGallery(): self
    {
        /** @var Image[] $images */
        $images = Image::whereIn('id', $this->images)
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
            'creator' => route('entity-creator.selection', $this->campaign),
        ];
    }

    protected function interactive(): void
    {
        $pusher = config('broadcasting.connections.reverb.key');
        if (empty($pusher) || ! isset($this->user)) {
            return;
        }

        if (!$this->user->can('update', $this->whiteboard->entity)) {
            return;
        }

        $this->data['interactive'] = [
            'key' => $pusher,
            'host' => config('broadcasting.connections.reverb.options.host'),
            'port' => config('broadcasting.connections.reverb.options.port'),
            'scheme' => config('broadcasting.connections.reverb.options.scheme'),
        ];
    }
}
