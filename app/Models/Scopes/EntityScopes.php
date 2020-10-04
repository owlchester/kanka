<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Trait EntityScopes
 * @package App\Models\Scopes
 *
 * @method static self|Builder recentlyModified()
 * @method static self|Builder unmentioned()
 * @method static self type(string $type)
 * @method static self|Builder inTags(array $tags)
 * @method static self|Builder templates(string $entityType)
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
            ->recentlyModified()
            ->leftJoin('entity_mentions as em', 'em.target_id', $this->getTable() . '.id')
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
}
