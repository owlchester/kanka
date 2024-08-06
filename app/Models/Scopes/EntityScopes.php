<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Trait EntityScopes
 * @package App\Models\Scopes
 *
 * @method static self|Builder recentlyModified()
 * @method static self|Builder inTags(array $tags)
 * @method static self|Builder inTypes(mixed $types)
 * @method static self|Builder templates(string $entityType)
 * @method static self|Builder apiFilter(array $requests)
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
                ->where("et{$v}.tag_id", $v)
            ;
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
    public function scopeApiFilter(Builder $query, array $request = []): Builder
    {
        $related = Arr::get($request, 'related', false);
        $types = Arr::get($request, 'types');
        if (!empty($types)) {
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

        // Other available:
        $filterableFields = [
            'name',
            'is_private',
            'is_template',
            'created_by',
            'updated_by',
            'tags',
        ];
        foreach ($request as $field => $value) {
            if (!in_array($field, $filterableFields)) {
                continue;
            }
            if (Str::startsWith($field, ['is_'])) {
                $bool = in_array($value, ['true', 1]) ? true : false;
                $query->where($field, $bool);
            } elseif (Str::endsWith($field, '_by')) {
                $query->where($field, (int) $value);
            } elseif ($field === 'tags') {
                // Something something tags
                if (!is_array($value)) {
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
                'events', 'events.entity',
                'inventories', 'inventories.entity',
                'relationships', 'abilities',
                'tags', 'image', 'assets',
            ] : ['tags', 'image'])
        ;
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
        if (!is_array($types)) {
            $types = [$types];
        }

        // Use to do [0] but that can be get unset by the exclude
        if (head($types) == 'all') {
            return $query;
        }

        return $query->whereIn($this->getTable() . '.type_id', $types);
    }
}
