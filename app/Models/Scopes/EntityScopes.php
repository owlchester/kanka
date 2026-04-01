<?php

namespace App\Models\Scopes;

use App\Enums\EntityAssetType;
use App\Enums\EntityEventTypes;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Trait EntityScopes
 *
 * @method static self|Builder recentlyModified()
 * @method static self|Builder inTags(array $tags)
 * @method static self|Builder inTypes(mixed $types)
 * @method static self|Builder templates(string $entityType)
 * @method static self|Builder apiFilter(array $requests)
 * @method static self|Builder order(array $config)
 * @method static self|Builder filter(array $filter)
 * @method static self|Builder filterHasFiles(bool $filter)
 * @method static self|Builder filterHasPost(bool $filter)
 * @method static self|Builder filterTags(array $tags, string $option)
 */
trait EntityScopes
{
    /**
     * Order entities by recently modified
     */
    public function scopeRecentlyModified(Builder $query): Builder
    {
        return $query
            ->orderBy($this->getTable() . '.updated_at', 'desc');
    }

    /**
     * Order entities by their olderst modified
     */
    public function scopeOldestModified(Builder $query): Builder
    {
        return $query
            ->orderBy($this->getTable() . '.updated_at', 'asc');
    }

    /**
     * Filter entities on specific tags
     */
    public function scopeInTags(Builder $query, ?array $tags = null): Builder
    {
        if (empty($tags)) {
            return $query;
        }

        $query->distinct()
            ->select($this->getTable() . '.*');

        foreach ($tags as $tag) {
            $v = (int) $tag;
            $query
                ->leftJoin('entity_tags as et' . $v, "et{$v}.entity_id", $this->getTable() . '.id')
                ->where("et{$v}.tag_id", $v);
        }

        return $query;
    }

    /**
     * Get entity templates of a specific entity type
     */
    public function scopeTemplates(Builder $query, int $entityTypeID): Builder
    {
        // @phpstan-ignore-next-line
        return $query
            ->template()
            ->where('type_id', $entityTypeID);
    }

    /**
     * Default API filter options
     */
    public function scopeApiFilter(Builder $query, Campaign $campaign, array $request = []): Builder
    {
        $related = Arr::get($request, 'related', false);
        $types = Arr::get($request, 'types');
        if (! empty($types)) {
            $typeNames = explode(',', $types);
            $typeIds = [];
            foreach ($typeNames as $type) {
                $id = config('entities.ids.' . $type);
                if (empty($id)) {
                    continue;
                }
                $typeIds[] = $id;
            }
            $query->whereIn('type_id', $typeIds);
        }

        $modules = Arr::get($request, 'type_id');
        if (! empty($modules) && is_array($modules)) {
            $validateModules = EntityType::inCampaign($campaign)->whereIn('id', $modules)->pluck('id')->toArray();
            if (! empty($validateModules)) {
                $query->whereIn('type_id', $validateModules);
            }
        }

        // Other available:
        $filterableFields = [
            'name',
            'is_private',
            'is_template',
            'created_by',
            'updated_by',
            'tags',
            'type',
        ];
        foreach ($request as $field => $value) {
            if (! in_array($field, $filterableFields)) {
                continue;
            }
            if (Str::startsWith($field, ['is_'])) {
                $bool = in_array($value, ['true', 1]) ? true : false;
                $query->where($field, $bool);
            } elseif (Str::endsWith($field, '_by')) {
                $query->where($field, (int) $value);
            } elseif ($field === 'tags') {
                // Something something tags
                if (! is_array($value)) {
                    $value = [$value];
                }
                $query
                    ->whereHas('tags', function ($query) use ($value) {
                        return $query->whereIn('tags.id', $value);
                    });
            } else {
                $query->where($field, 'LIKE', '%' . $value . '%');
            }
        }

        return $query
            ->with($related ? [
                'attributes', 'attributes.entity',
                'posts', 'posts.permissions', 'posts.entity',
                'reminders', 'reminders.remindable',
                'inventories', 'inventories.entity',
                'relationships', 'abilities',
                'tags', 'image', 'assets',
                'entityType',
                'locations' => function ($query) {
                    $query->select('locations.id');
                },
            ] : ['tags', 'image', 'entityType',
                'locations' => function ($query) {
                    $query->select('locations.id');
                },
            ]);
    }

    /**
     * Filter entities on specific types.
     * Valid option is 'all'
     */
    public function scopeInTypes(Builder $query, mixed $types = null): Builder
    {
        if (empty($types)) {
            return $query;
        }
        if (! is_array($types)) {
            $types = [$types];
        }

        // Use to do [0] but that can be get unset by the exclude
        if (head($types) == 'all') {
            return $query;
        }

        return $query->whereIn($this->getTable() . '.type_id', $types);
    }

    public function scopeOrder(Builder $query, array $config = [], ?EntityType $entityType = null): Builder
    {
        $entityFields = ['name', 'type', 'is_private'];

        foreach ($config as $field => $order) {
            if ($field === 'parent.name') {
                $query->leftJoin('entities as parent_order', 'parent_order.id', '=', 'entities.parent_id')
                    ->orderBy('parent_order.name', $order);
            } elseif ($field === 'calendar_date') {
                $query->leftJoin('reminders as cd', function ($join) {
                    $join->on('cd.remindable_id', '=', 'entities.id')
                        ->on('cd.remindable_type', '=', DB::raw("'" . addslashes(Entity::class) . "'"))
                        ->where('cd.type_id', EntityEventTypes::calendarDate);
                })
                    ->orderBy('cd.year', $order)
                    ->orderBy('cd.month', $order)
                    ->orderBy('cd.day', $order);
            } elseif ($field === 'tags') {
                $query->leftJoin('entity_tags as tags_order', 'tags_order.entity_id', '=', 'entities.id')
                    ->leftJoin('tags as tag_order', 'tag_order.id', '=', 'tags_order.tag_id')
                    ->orderBy('tag_order.name', $order);
            } elseif (! in_array($field, $entityFields) && $entityType?->isStandard()) {
                // Field lives on the child model's table
                $childModel = $entityType->getClass();
                $childTable = $childModel->getTable();
                $query->leftJoin($childTable . ' as child_order', 'child_order.id', '=', 'entities.entity_id');

                $segments = explode('.', $field);
                if (count($segments) > 1) {
                    // Dotted field like location.name — resolve the relationship on the child model
                    $relationName = $segments[0];
                    /** @var BelongsTo $relation */
                    $relation = $childModel->{$relationName}();
                    $relatedTable = $relation->getQuery()->getQuery()->from;
                    $query->leftJoin(
                        $relatedTable . ' as orderable_j',
                        'orderable_j.id',
                        'child_order.' . $relation->getForeignKeyName()
                    )->orderBy(str_replace($relationName, 'orderable_j', $field), $order);
                } else {
                    $query->orderBy('child_order.' . $field, $order);
                }
            } else {
                $query->orderBy('entities.' . $field, $order);
            }
        }

        return $query;
    }

    public function scopeFilter(Builder $query, array $filters = [], ?EntityType $entityType = null): Builder
    {
        $childFilterKeys = [];
        foreach ($filters as $name => $values) {
            // Skip null or empty-string values (empty form fields)
            if ($values === null || $values === '') {
                continue;
            } elseif (is_array($values) && empty(array_filter($values, fn ($v) => $v !== '' && $v !== null))) {
                continue;
            } elseif (in_array($name, ['is_private', 'parent_id'])) {
                $query->where('entities.' . $name, $values);
            } elseif (in_array($name, ['name', 'type'])) {
                // @phpstan-ignore-next-line
                $query->textFilter($name, $values);
            } elseif (in_array($name, ['has_image', 'template'])) {
                $property = 'is_template';
                if ($name === 'has_image') {
                    $property = 'image_uuid';
                }

                if ($values) {
                    $query->whereNotNull($property);
                } else {
                    $query->whereNull($property);
                }
            } elseif ($name === 'archived') {
                if ($values) {
                    $query->whereNotNull('archived_at');
                }
            } elseif ($name === 'has_entity_files') {
                // @phpstan-ignore-next-line
                $query->filterHasFiles($values);
            } elseif ($name === 'has_posts') {
                // @phpstan-ignore-next-line
                $query->filterHasPosts($values);
            } elseif ($name === 'has_entry') {
                // @phpstan-ignore-next-line
                $query->filterHasEntry($values);
            } elseif ($name === 'has_attributes') {
                // @phpstan-ignore-next-line
                $query->filterHasAttributes($values);
            } elseif (in_array($name, ['attribute_name', 'attribute_value'])) {
                // attribute_value is handled together with attribute_name
                if ($name === 'attribute_name') {
                    // @phpstan-ignore-next-line
                    $query->filterAttributes($values, Arr::get($filters, 'attribute_value'));
                }
            } elseif (in_array($name, ['connection_target', 'connection_name'])) {
                // connection_name is handled together with connection_target
                if ($name === 'connection_target' || ! isset($filters['connection_target'])) {
                    // @phpstan-ignore-next-line
                    $query->filterConnections(
                        Arr::get($filters, 'connection_target'),
                        Arr::get($filters, 'connection_name')
                    );
                }
            } elseif (in_array($name, ['created_by', 'updated_by'])) {
                $query->where('entities.' . $name, (int) $values);
            } elseif ($name === 'creators') {
                // Handled after the loop (like tags) so that creators_option works even with an empty array
                continue;
            } elseif ($name === 'tags') {
                // Handled after the loop so that tags_option works even with an empty array
                continue;
            } elseif ($entityType?->isStandard() && ! Str::endsWith($name, '_option')) {
                $childFilterKeys[$name] = $values;
            }
        }

        // Entity-type-specific filters (e.g. status_id on characters)
        if (! empty($childFilterKeys) && $entityType?->isStandard()) {
            $childModel = $entityType->getClass();
            $childTable = $childModel->getTable();
            $query->leftJoin($childTable . ' as child_filter', 'child_filter.id', '=', 'entities.entity_id');
            foreach ($childFilterKeys as $name => $values) {
                $ids = collect((array) $values)->map(fn ($v) => (int) $v)->toArray();
                $option = Arr::get($filters, $name . '_option');
                if ($name === 'families') {
                    if ($option === 'children') {
                        $ids = Entity::whereIn('entity_id', $ids)
                            ->where('type_id', config('entities.ids.family'))
                            ->with('descendants')
                            ->get()
                            ->flatMap(fn ($e) => [$e->entity_id, ...$e->descendants->pluck('entity_id')->toArray()])
                            ->unique()
                            ->toArray();
                    }
                    if ($option === 'exclude') {
                        $query->whereRaw('(select count(*) from `character_family` where `character_family`.`character_id` = `child_filter`.`id` and `character_family`.`family_id` in (' . implode(', ', $ids) . ')) = 0');
                    } else {
                        $query->whereExists(fn ($q) => $q->select(DB::raw(1))->from('character_family')->whereColumn('character_family.character_id', 'child_filter.id')->whereIn('character_family.family_id', $ids));
                    }
                } elseif ($name === 'races') {
                    if ($option === 'children') {
                        $ids = Entity::whereIn('entity_id', $ids)
                            ->where('type_id', config('entities.ids.race'))
                            ->with('descendants')
                            ->get()
                            ->flatMap(fn ($e) => [$e->entity_id, ...$e->descendants->pluck('entity_id')->toArray()])
                            ->unique()
                            ->toArray();
                    }
                    if ($option === 'exclude') {
                        $query->whereRaw('(select count(*) from `character_race` where `character_race`.`character_id` = `child_filter`.`id` and `character_race`.`race_id` in (' . implode(', ', $ids) . ')) = 0');
                    } else {
                        $query->whereExists(fn ($q) => $q->select(DB::raw(1))->from('character_race')->whereColumn('character_race.character_id', 'child_filter.id')->whereIn('character_race.race_id', $ids));
                    }
                } elseif ($name === 'organisations') {
                    if ($option === 'children') {
                        $ids = Entity::whereIn('entity_id', $ids)
                            ->where('type_id', config('entities.ids.organisation'))
                            ->with('descendants')
                            ->get()
                            ->flatMap(fn ($e) => [$e->entity_id, ...$e->descendants->pluck('entity_id')->toArray()])
                            ->unique()
                            ->toArray();
                    }
                    if ($option === 'exclude') {
                        $query->whereRaw('(select count(*) from `organisation_member` where `organisation_member`.`character_id` = `child_filter`.`id` and `organisation_member`.`organisation_id` in (' . implode(', ', $ids) . ')) = 0');
                    } else {
                        $query->whereExists(fn ($q) => $q->select(DB::raw(1))->from('organisation_member')->whereColumn('organisation_member.character_id', 'child_filter.id')->whereIn('organisation_member.organisation_id', $ids));
                    }
                } elseif ($name === 'locations') {
                    if ($option === 'children') {
                        $ids = Entity::whereIn('entity_id', $ids)
                            ->where('type_id', config('entities.ids.location'))
                            ->with('descendants')
                            ->get()
                            ->flatMap(fn ($e) => [$e->entity_id, ...$e->descendants->pluck('entity_id')->toArray()])
                            ->unique()
                            ->toArray();
                    }
                    if ($option === 'exclude') {
                        $query->whereRaw('(select count(*) from `entity_locations` where `entity_locations`.`entity_id` = `entities`.`id` and `entity_locations`.`location_id` in (' . implode(', ', $ids) . ')) = 0');
                    } else {
                        $query->whereExists(fn ($q) => $q->select(DB::raw(1))->from('entity_locations')->whereColumn('entity_locations.entity_id', 'entities.id')->whereIn('entity_locations.location_id', $ids));
                    }
                } else {
                    $query->where('child_filter.' . $name, $values);
                }
            }
        }

        if (Arr::hasAny($filters, ['tags', 'tags_option'])) {
            // @phpstan-ignore-next-line
            $query->filterTags(Arr::get($filters, 'tags', []), Arr::get($filters, 'tags_option'));
        }

        // Creators filter (handled outside loop so creators_option works even with empty array)
        if (Arr::hasAny($filters, ['creators', 'creators_option'])) {
            $creatorsOption = Arr::get($filters, 'creators_option');
            if ($creatorsOption === 'none') {
                $query->whereNotExists(function ($sub) {
                    $sub->selectRaw(1)
                        ->from('item_creator')
                        ->whereColumn('item_creator.item_id', 'entities.entity_id');
                });
            } else {
                $creatorValues = Arr::get($filters, 'creators', []);
                $creatorIds = array_values(array_filter(array_map('intval', is_array($creatorValues) ? $creatorValues : [$creatorValues])));
                if (! empty($creatorIds)) {
                    if ($creatorsOption === 'exclude') {
                        foreach ($creatorIds as $creatorId) {
                            $query->whereNotExists(function ($sub) use ($creatorId) {
                                $sub->selectRaw(1)
                                    ->from('item_creator')
                                    ->whereColumn('item_creator.item_id', 'entities.entity_id')
                                    ->where('item_creator.creator_id', $creatorId);
                            });
                        }
                    } else {
                        foreach ($creatorIds as $creatorId) {
                            $query->whereExists(function ($sub) use ($creatorId) {
                                $sub->selectRaw(1)
                                    ->from('item_creator')
                                    ->whereColumn('item_creator.item_id', 'entities.entity_id')
                                    ->where('item_creator.creator_id', $creatorId);
                            });
                        }
                    }
                }
            }
        }

        return $query;
    }

    /**
     * Filter on entities with files
     */
    protected function scopeFilterHasFiles(Builder $query, bool $value = true): void
    {
        $query
            ->leftJoin('entity_assets', 'entity_assets.entity_id', '=', 'entities.id')
            ->where('entity_assets.type_id', EntityAssetType::file);

        if ($value) {
            $query->whereNotNull('entity_assets.id');
        } else {
            $query->whereNull('entity_assets.id');
        }
    }

    /**
     * Filter on entities with posts
     */
    protected function scopeFilterHasPosts(Builder $query, bool $value = true): void
    {
        $query
            ->leftJoin('posts', 'posts.entity_id', 'entities.id');

        if ($value) {
            $query->whereNotNull('posts.id');
        } else {
            $query->whereNull('posts.id');
        }
    }

    /**
     * Filter on entities with posts
     */
    protected function scopeFilterHasEntry(Builder $query, bool $value = true): void
    {
        if ($value) {
            $query->whereNotNull('entities.entry')
                ->where('entities.entry', '!=', '');
        } else {
            $query->whereNull('entities.entry')
                ->orWhere('entities.entry', '');
        }
    }

    /**
     * Filter on entities with specific tags
     */
    protected function scopeFilterTags(Builder $query, array $tags = [], ?string $type = null): void
    {
        // Gets handled differently for some reason?
        if ($type === 'none') {
            $query
                ->leftJoin('entity_tags as no_tags', 'no_tags.entity_id', 'entities.id')
                ->whereNull('no_tags.tag_id');

            return;
        } elseif ($type === 'exclude') {
            $tagIds = [];
            foreach ($tags as $v) {
                $tagIds[] = (int) $v;
            }
            // $query->leftJoin('entity_tags as et_tags', "et_tags.entity_id", 'e.id')
            $query->whereRaw('(
                select count(*) from entity_tags as et
                where et.entity_id = entities.id and et.tag_id in (' . implode(', ', $tagIds) . ')
            ) = 0');

            return;
        }

        foreach ($tags as $v) {
            if (! is_numeric($v)) {
                continue;
            }
            $v = (int) $v;
            $query
                ->leftJoin('entity_tags as et' . $v, "et{$v}.entity_id", 'entities.id')
                ->where("et{$v}.tag_id", $v);
        }
    }

    protected function scopeTextFilter(Builder $query, string $field, ?string $value = null): Builder
    {
        $searchTerms = explode(';', $value);
        foreach ($searchTerms as $searchTerm) {
            if (empty($searchTerm) && $searchTerm != '0') {
                continue;
            }
            [$operator, $text] = $this->extractSearchOperator($searchTerm, 'type');
            $searchTerm = $text;

            $query->where(
                'entities.' . $field,
                $operator,
                ($operator == '=' ? $text : "%{$searchTerm}%")
            );
        }

        return $query;
    }

    /**
     * Filter on entities with attributes
     */
    protected function scopeFilterHasAttributes(Builder $query, bool $value = true): void
    {
        $query
            ->leftJoin('attributes', 'attributes.entity_id', 'entities.id');

        if ($value) {
            $query->whereNotNull('attributes.id');
        } else {
            $query->whereNull('attributes.id');
        }
    }

    /**
     * Filter on entities by attribute name and optionally value
     */
    protected function scopeFilterAttributes(Builder $query, ?string $name = null, ?string $attributeValue = null): void
    {
        if ($name === null) {
            return;
        }

        [$operator, $filterName] = $this->extractSearchOperator($name, 'attribute_name');

        // No attribute with this name (exclude)
        if ($operator === 'not like') {
            $query
                ->whereRaw('(select count(*) from attributes as att where att.entity_id = entities.id and att.name = ?) = 0', [$filterName]);

            return;
        }

        $query
            ->leftJoin('attributes as att', 'att.entity_id', '=', 'entities.id')
            ->where('att.name', $filterName);

        if ($attributeValue === '!') {
            $query->whereRaw('att.value <> ""');
        } elseif ($attributeValue !== '' && $attributeValue !== null) {
            $query->where('att.value', $attributeValue);
        }
    }

    /**
     * Filter on entities by their connections
     */
    protected function scopeFilterConnections(Builder $query, ?string $targetId = null, ?string $connectionName = null): void
    {
        $query
            ->leftJoin('relations as rel', 'rel.owner_id', '=', 'entities.id');

        if ($targetId !== '' && $targetId !== null) {
            $query->where('rel.target_id', $targetId);
        }

        if ($connectionName !== '' && $connectionName !== null) {
            [$operator, $filterName] = $this->extractSearchOperator($connectionName, 'connection_name');
            $searchValue = $operator === '=' ? $filterName : '%' . $filterName . '%';
            $query->where('rel.relation', $operator, $searchValue);
        }
    }

    /**
     * @param  string|array  $value  (array for tags)
     */
    protected function extractSearchOperator(mixed $value, string $key): array
    {
        $operator = 'like';
        $filterValue = $value;
        if ($value == '!!') {
            $operator = 'IS NULL';
            $filterValue = null;
        } elseif (Str::startsWith($value, '!')) {
            $operator = 'not like';
            $filterValue = mb_ltrim($value, '!');
        } elseif (Str::endsWith($value, '!')) {
            $operator = '=';
            $filterValue = mb_rtrim($value, '!');
        } elseif (Str::endsWith($key, '_id')) {
            $operator = '=';
        }

        return [$operator, $filterValue];
    }
}
