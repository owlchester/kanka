<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Trait EntityScopes
 * @package App\Models\Scopes
 *
 * @method static self|Builder recentlyModified()
 * @method static self|Builder unmentioned()
 * @method static self|Builder mentionless()
 * @method static self type(string $type)
 * @method static self|Builder inTags(array $tags)
 * @method static self|Builder inTypes(array $types)
 * @method static self|Builder templates(string $entityType)
 * @method static self|Builder apiFilter(array $requests)
 */
trait EntityScopes
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeTop(Builder $query)
    {
        return $query
            ->select('*', DB::raw('count(id) as cpt'))
            ->groupBy('type')
            ->orderBy('cpt', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecentlyModified(Builder $query)
    {
        return $query
            ->orderBy($this->getTable() . '.updated_at', 'desc');
    }

    /**
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeType(Builder $query, $type)
    {
        if (empty($type)) {
            return $query;
        }
        return $query->where('type', $type);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeStandardWith(Builder $query)
    {
        return $query->with('tags');
    }

    /**
     * @param Builder $query
     * @param array|null $tags
     * @return mixed
     */
    public function scopeInTags(Builder $query, array $tags = null)
    {
        if (empty($tags)) {
            return $query;
        }

        $query->distinct()
            ->select($this->getTable() . '.*');

        foreach ($tags as $tag) {
            $v = (int) $tag;
            $query
                ->leftJoin('entity_tags as et' . $v, "et$v.entity_id", $this->getTable() . '.id')
                ->where("et$v.tag_id", $v)
            ;
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnmentioned(Builder $query)
    {
        return $query->select($this->getTable() . '.*')
            ->leftJoin('entity_mentions as em', 'em.target_id', $this->getTable() . '.id')
            ->whereNull('em.id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeMentionless(Builder $query)
    {
        return $query->select($this->getTable() . '.*')
            ->leftJoin('entity_mentions as em', 'em.entity_id', $this->getTable() . '.id')
            ->whereNull('em.id');
    }

    /**
     * @param Builder $query
     * @param string $entityType
     * @return Builder
     */
    public function scopeTemplates(Builder $query, string $entityType)
    {
        return $query
            ->where('type', $entityType)
            ->where('is_template', 1);
    }

    /**
     * @param Builder $query
     * @param array $request
     * @return Builder
     */
    public function scopeApiFilter(Builder $query, array $request = [])
    {
        $related = Arr::get($request, 'related', false);
        $types = Arr::get($request, 'types');
        if (!empty($types)) {
            $types = explode(',', $types);
            $query->whereIn('type', $types);
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
                'attributes', 'notes', 'events', 'files', 'relationships', 'inventories', 'abilities', 'tags', 'links', 'image'] : ['tags', 'image'])
        ;
    }

    /**
     * @param Builder $query
     * @param array|null $types
     * @return Builder
     */
    public function scopeInTypes(Builder $query, array $types = null)
    {
        if (empty($types) || !is_array($types)) {
            return $query;
        }

        if ($types[0] == 'all') {
            return $query;
        }

        return $query->whereIn('type', $types);
    }
}
