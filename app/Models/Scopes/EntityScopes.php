<?php

namespace App\Models\Scopes;

use App\Models\Campaign;
use App\Models\EntityType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
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
            ] : ['tags', 'image', 'entityType']);
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

    public function scopeOrder(Builder $query, array $config = []): Builder
    {
        foreach ($config as $field => $order) {
            $query->orderBy($field, $order);
        }

        return $query;
    }

    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        foreach ($filters as $name => $values) {
            if (! is_array($values) && $values === null) {
                continue;
            } elseif (in_array($name, ['is_private', 'parent_id'])) {
                $query->where($name, $values);
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
            }
        }

        if (Arr::hasAny($filters, ['tags', 'tags_option'])) {
            // @phpstan-ignore-next-line
            $query->filterTags(Arr::get($filters, 'tags', []), Arr::get($filters, 'tags_option'));
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
            ->where('entity_assets.type_id', \App\Enums\EntityAssetType::FILE->value);

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
                $field,
                $operator,
                ($operator == '=' ? $text : "%{$searchTerm}%")
            );
        }

        return $query;
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
