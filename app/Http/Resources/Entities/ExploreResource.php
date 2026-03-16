<?php

namespace App\Http\Resources\Entities;

use App\Facades\Avatar;
use App\Facades\CampaignLocalization;
use App\Http\Resources\EntityTypeResource;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ExploreResource extends JsonResource
{
    protected static array $columnKeys = [];

    public static function withColumns(array $keys): void
    {
        static::$columnKeys = $keys;
    }

    protected function hasColumn(string $key): bool
    {
        return empty(static::$columnKeys) || in_array($key, static::$columnKeys);
    }

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

        $showParams = [$campaign, $entity];
        if ($request->filled('bookmark')) {
            $showParams['bookmark'] = $request->get('bookmark');
        }

        $data = [
            'id' => $entity->id,
            'name' => $entity->name,
            'type' => $entity->type,
            'type_slug' => Str::slug($entity->type ?? ''),
            'attributes' => $attributes,
            'selected' => false,
            'children' => $entity->children_count,
            'images' => [
                'thumb' => Avatar::entity($entity)->fallback()->size(192, 144)->thumbnail(),
                'full' => Avatar::entity($entity)->original(),
            ],
            'is_private' => $entity->is_private,
            'parent_id' => $entity->parent_id,
            'entityType' => new EntityTypeResource($entity->entityType),
            'urls' => [
                'tooltip' => route('entities.tooltip', [$campaign, $entity]),
                'show' => route('entities.show', $showParams),
                'children' => route('entities.index', [$campaign, $entity->entityType, 'parent_id' => $entity->id]),
                'children_api' => route('entities.index-api', [$campaign, $entity->entityType, 'parent_id' => $entity->id, 'children' => true]),
                'parent' => $routeBack,
                'parent_api' => $entity->parent_id
                    ? route('entities.index-api', array_merge($routeParams, ['parent_id' => $entity->parent_id]))
                    : route('entities.index-api', $routeParams),
            ],
            'tags' => $this->tags(),
            'links' => $links,
        ];

        // Column-driven entity-type-specific data
        $child = $entity->child;
        if ($child) {
            if ($this->hasColumn('title') && isset($child->title)) {
                $data['title'] = $child->title;
            }
            if ($this->hasColumn('date') && isset($child->date)) {
                $data['date'] = $child->date;
            }
            if ($this->hasColumn('price') && isset($child->price)) {
                $data['price'] = $child->price;
            }
            if ($this->hasColumn('size') && isset($child->size)) {
                $data['size'] = $child->size;
            }
            if ($this->hasColumn('colour') && isset($child->colour)) {
                $data['colour'] = $child->colour;
            }
            if ($this->hasColumn('status')) {
                $data['status'] = method_exists($child, 'isDead') ? $child->isDead() :
                                 (method_exists($child, 'isDefunct') ? $child->isDefunct() : false);
            }
            if ($this->hasColumn('is_destroyed') && isset($child->is_destroyed)) {
                $data['is_destroyed'] = (bool) $child->is_destroyed;
            }
            if ($this->hasColumn('is_defunct') && isset($child->is_defunct)) {
                $data['is_defunct'] = (bool) $child->is_defunct;
            }
            if ($this->hasColumn('is_extinct') && isset($child->is_extinct)) {
                $data['is_extinct'] = (bool) $child->is_extinct;
            }
            if ($this->hasColumn('is_dead') && isset($child->is_dead)) {
                $data['is_dead'] = (bool) $child->is_dead;
            }
            if ($this->hasColumn('is_auto_applied') && isset($child->is_auto_applied)) {
                $data['is_auto_applied'] = (bool) $child->is_auto_applied;
            }
            if ($this->hasColumn('is_hidden') && isset($child->is_hidden)) {
                $data['is_hidden'] = (bool) $child->is_hidden;
            }
            if ($this->hasColumn('location')) {
                $data['location'] = $this->formatSingleEntity($child->location ?? null);
            }
            if ($this->hasColumn('author') && method_exists($child, 'author')) {
                $data['author'] = $this->formatSingleEntity($child->author ?? null);
            }
            if ($this->hasColumn('instigator') && method_exists($child, 'instigator')) {
                $data['instigator'] = $this->formatSingleEntity($child->instigator ?? null);
            }
            if ($this->hasColumn('families') && method_exists($child, 'characterFamilies')) {
                $data['families'] = $this->formatRelatedEntities($child, 'characterFamilies', 'family');
            }
            if ($this->hasColumn('races') && method_exists($child, 'characterRaces')) {
                $data['races'] = $this->formatRelatedEntities($child, 'characterRaces', 'race');
            }
            // Count columns
            if ($this->hasColumn('members_count') && isset($child->members_count)) {
                $data['members_count'] = $child->members_count ?? 0;
            }
            if ($this->hasColumn('elements_count') && isset($child->elements_count)) {
                $data['elements_count'] = $child->elements_count ?? 0;
            }
            if ($this->hasColumn('eras_count') && isset($child->eras_count)) {
                $data['eras_count'] = $child->eras_count ?? 0;
            }
            if ($this->hasColumn('entities_count') && isset($child->entities_count)) {
                $data['entities_count'] = $child->entities_count ?? 0;
            }
        }

        // Calendar date (lives on entity, not child)
        if ($this->hasColumn('calendar_date')) {
            $data['calendar_date'] = $this->formatCalendarDate($entity);
        }

        // Parent entity link
        if ($this->hasColumn('parent') && $entity->parent) {
            $data['parent_entity'] = $this->formatSingleEntity($entity->parent);
        }

        // Entity locations (many-to-many)
        if ($this->hasColumn('locations') && $entity->relationLoaded('locations')) {
            $data['locations'] = $this->formatEntityLocations($entity);
        }

        // Children preview for grid avatar bubbles
        if ($entity->relationLoaded('children')) {
            $data['children_preview'] = $entity->children->take(3)->map(fn ($child) => [
                'id' => $child->id,
                'name' => $child->name,
                'image' => Avatar::entity($child)->fallback()->size(40, 40)->thumbnail(),
            ])->toArray();
        }

        return $data;
    }

    protected function tags(): array
    {
        /** @var Entity $entity */
        $entity = $this->resource;

        $tags = [];
        $campaign = CampaignLocalization::getCampaign();
        foreach ($entity->visibleTags() as $tag) {
            $tags[] = [
                'id' => $tag->id,
                'urls' => [
                    'show' => route('entities.show', [$campaign, $tag->entity]),
                ],
                'name' => $tag->name,
                'colour' => $tag->colourClass(),
                'shortname' => $tag->shortname(),
            ];
        }

        return $tags;
    }

    protected function formatRelatedEntities(mixed $child, string $pivotRelation, string $entityRelation): array
    {
        if (! method_exists($child, $pivotRelation)) {
            return [];
        }

        $items = [];
        $campaign = CampaignLocalization::getCampaign();
        foreach ($child->{$pivotRelation} as $pivot) {
            $related = $pivot->{$entityRelation};
            if ($related && $related->entity) {
                $items[] = [
                    'id' => $related->entity->id,
                    'name' => $related->entity->name,
                    'url' => route('entities.show', [$campaign, $related->entity]),
                ];
            }
        }

        return $items;
    }

    protected function formatSingleEntity(mixed $model): ?array
    {
        if (! $model || ! $model->entity) {
            return null;
        }

        $campaign = CampaignLocalization::getCampaign();

        return [
            'id' => $model->entity->id,
            'name' => $model->entity->name,
            'url' => route('entities.show', [$campaign, $model->entity]),
        ];
    }

    protected function formatCalendarDate(Entity $entity): ?array
    {
        if (! $entity->relationLoaded('calendarDate') || ! $entity->calendarDate) {
            return null;
        }

        $reminder = $entity->calendarDate;
        if (! $reminder->calendar || ! $reminder->calendar->entity) {
            return null;
        }

        $campaign = CampaignLocalization::getCampaign();

        return [
            'date' => $reminder->readableDate(),
            'url' => route('entities.show', [
                $campaign,
                $reminder->calendar->entity,
                'month' => $reminder->month,
                'year' => $reminder->year,
            ]),
        ];
    }

    protected function formatEntityLocations(Entity $entity): array
    {
        $items = [];
        $campaign = CampaignLocalization::getCampaign();
        foreach ($entity->locations as $location) {
            if ($location->entity) {
                $items[] = [
                    'id' => $location->entity->id,
                    'name' => $location->entity->name,
                    'url' => route('entities.show', [$campaign, $location->entity]),
                ];
            }
        }

        return $items;
    }
}
