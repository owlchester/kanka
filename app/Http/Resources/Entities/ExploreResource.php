<?php

namespace App\Http\Resources\Entities;

use App\Facades\Avatar;
use App\Facades\CampaignLocalization;
use App\Http\Resources\EntityTagResource;
use App\Http\Resources\EntityTypeResource;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ExploreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Entity $entity */
        $entity = $this->resource;
        $campaign = CampaignLocalization::getCampaign();
        $attributes = [];
        if ($entity->is_private) {
            $attributes[] = 'private';
        }
        if ($entity->isCharacter() && $entity->character->isDead()) {
            $attributes[] = 'dead';
        } elseif ($entity->isOrganisation() && $entity->organisation->isDefunct()) {
            $attributes[] = 'defunct';
        } elseif ($entity->isCreature() && $entity->creature->isExtinct()) {
            $attributes[] = 'extinct';
        } elseif ($entity->isQuest() && $entity->quest->isCompleted()) {
            $attributes[] = 'completed';
        }

        $routeParams = [$campaign, $entity->entityType];
        $links = ['back' => __('crud.actions.back')];
        if ($entity->parent) {
            $routeParams['parent_id'] = $entity->parent;
            $links['back'] = __('datagrids.actions.back_to', ['name' => $entity->parent->name]);
        }
        $routeBack = route('entities.index', $routeParams);

        $data = [
            'id' => $entity->id,
            'name' => $entity->name,
            'type' => Str::slug($entity->type),
            'attributes' => $attributes,
            'selected' => false,
            'children' => $entity->children_count,
            'images' => [
                'thumb' => Avatar::entity($entity)->fallback()->size(192, 144)->thumbnail(),
                'full' => Avatar::entity($entity)->original(),
            ],
            'is_private' => $entity->is_private,
            'entityType' => new EntityTypeResource($entity->entityType),
            'urls' => [
                'tooltip' => route('entities.tooltip', [$campaign, $entity]),
                'show' => route('entities.show', [$campaign, $entity]),
                'children' => route('entities.index', [$campaign, $entity->entityType, 'parent_id' => $entity->id]),
                'children_api' => route('entities.index-api', [$campaign, $entity->entityType, 'parent_id' => $entity->id, 'children' => true]),
                'parent' => $routeBack,
            ],
            'tags' => $this->tags(),
            'links' => $links,
        ];

        return $data;
    }

    protected function css(): ?string
    {
        /** @var Entity $entity */
        $entity = $this->resource;

        if ($entity->isCharacter() && $entity->character->isDead()) {
            return 'dead';
        }
        return null;
    }

    protected function tags(): array
    {
        /** @var Entity $entity */
        $entity = $this->resource;

        $tags = [];
        $campaign = CampaignLocalization::getCampaign();
        foreach ($entity->visibleTags as $tag) {
            $tags[] = [
                'id' => $tag->id,
                'urls' => [
                    'show' => route('entities.show', [$campaign, $tag->entity]),
                ],
                'name' => $tag->name,
                'colour' => $tag->colourClass(),
                'shortname' => $tag->shortname()
            ];
        }
        return $tags;
    }
}
