<?php

namespace App\Models\Concerns;

use App\Enums\FilterOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Location;
use App\Models\Family;
use App\Models\Race;

/**
 * HasFilters
 *
 * This trait adds support on models to call the filter() scope.
 * This takes parameters passed by the controller and only includes fields that are whitelisted. Whitelisted filters
 * are combined between
 * @method static self|Builder filter(?array $params = null)
 */
trait HasFilters
{
    protected string|array|null $filterValue;

    /** @var string|null Some filters have a fellow _option field that can define more in detail what is needed */
    protected string|null $filterOption;

    /** @var string The operator for the SQL search. For example <>, %%, %{term}, etc */
    protected string $filterOperator;

    protected array $filterParams = [];

    /**
     * Get all available filterable columns of the entity. Merge the custom
     * with the default ones (if not overwritten)
     */
    public function getFilterableColumns(): array
    {
        $custom = [];
        if (method_exists($this, 'filterableColumns')) {
            $custom = $this->filterableColumns();
        }
        $default = $this->defaultFilterableColumns();
        return array_unique(array_merge($custom, $default));
    }

    /**
     * Default available filterable columns to every model using the HasFilters trait.
     * @return string[]
     */
    protected function defaultFilterableColumns(): array
    {
        return [
            'name',
            'type',
            'is_private',
            'template',
            'tag_id',
            'tags',
            'has_image',
            'has_posts',
            'has_entity_files',
            'has_attributes',
            'created_by',
            'updated_by',
            'attribute_name',
            'attribute_value',
            'connections',
            'connection_target',
            'connection_name'
        ];
    }

    /**
     */
    public function scopeFilter(Builder $query, array $params = []): Builder
    {
        $fields = $this->getFilterableColumns();
        if (!is_array($params) || empty($params) || empty($fields)) {
            return $query;
        }

        $this->filterParams = $params;

        foreach ($this->filterParams as $key => $value) {
            if (isset($value) && in_array($key, $fields)) {
                // The requested field is an array, which we don't support for anything other than tags ("or" searches)
                if (is_array($value) && $key != "tags") {
                    continue;
                }
                $this->filterOption = !empty($params[$key . '_option']) ? $params[$key . '_option'] : null;
                $this->extractSearchOperator($value, $key);

                // Foreign key search
                $segments = explode('-', $key);
                if (count($segments) > 1) {
                    $this->foreign($query, $segments[0], $key);
                    return $query;
                }

                // Explicit filters (numbers typically, foreign ids)
                if (in_array($key, $this->explicitFilters())) {
                    if ($this->filterOperator == 'IS NULL') {
                        $query->whereNull($this->getTable() . '.' . $key);
                    } else {
                        $query->where($this->getTable() . '.' . $key, $this->filterOperator, $this->filterValue);
                    }

                    continue;
                }

                if ($key === 'tags') {
                    $this->filterTags($query, $value);
                } elseif (in_array($key, ['date_start' , 'date_end'])) {
                    $this->filterDateRange($query, $key, $params);
                } elseif ($key == 'races') {
                    $this->filterRaces($query, $value);
                } elseif ($key == 'location_id') {
                    $this->filterLocations($query, $value, $key);
                } elseif ($key == 'tag_id') {
                    $query
                        ->joinEntity()
                        ->leftJoin('entity_tags as et', 'et.entity_id', 'e.id')
                        ->where('et.tag_id', $value);
                } elseif (in_array($key, ['attribute_value', 'attribute_name'])) {
                    $this->filterAttributes($query, $key);
                } elseif (in_array($key, ['connection_target', 'connection_name'])) {
                    $this->filterConnections($query, $key);
                } elseif ($key == 'race_id') {
                    $this->filterRace($query, $value);
                } elseif ($key == 'family_id') {
                    $this->filterFamily($query, $value);
                } elseif ($key == 'member_id') {
                    $this->filterMember($query, $value);
                } elseif ($key == 'quest_element_id') {
                    $query->element($value, $this->getFilterOption());
                } elseif ($key == 'element_role') {
                    $query->elementRole($value, $this->filterOperator);
                } elseif ($key == 'has_image') {
                    $this->filterHasImage($query, $value);
                } elseif ($key == 'template') {
                    $this->filterTemplate($query, $value);
                } elseif ($key == 'has_posts') {
                    $this->filterHasPosts($query, $value);
                } elseif ($key == 'is_equipped') {
                    $this->filterIsEquipped($query, $value);
                } elseif ($key == 'has_attributes') {
                    $this->filterHasAttributes($query, $value);
                } elseif ($key == 'has_entity_files') {
                    $this->filterHasFiles($query, $value);
                } elseif ($key == 'parent') {
                    $this->filterParent($query);
                } elseif (in_array($key, ['created_by', 'updated_by'])) {
                    $query
                        ->joinEntity()
                        ->where('e.' . $key, (int) $value);
                } elseif ($this->filterOperator === 'IS NULL') {
                    $query->where(function ($sub) use ($key) {
                        $sub->whereNull($this->getTable() . '.' . $key)
                            ->orWhere($this->getTable() . '.' . $key, '=', '');
                    });
                } else {
                    // If we have an exclude option filter, change the operator
                    $this->filterFallback($query, $key);
                }
            } elseif (Str::endsWith($key, '_option') && $value == 'none') {
                $this->filterNoneOptions($query, $key, $fields);
            }
        }
        return $query;
    }

    /**
     * @param string|array $value (array for tags)
     */
    protected function extractSearchOperator($value, string $key): void
    {
        $operator = 'like';
        $filterValue = $value;
        if (($key !== 'tags') && ($key !== 'races')) {
            if ($value == '!!') {
                $operator = 'IS NULL';
                $filterValue = null;
            } elseif (Str::startsWith($value, '!')) {
                $operator = 'not like';
                $filterValue = ltrim($value, '!');
            } elseif (Str::endsWith($value, '!')) {
                $operator = '=';
                $filterValue = rtrim($value, '!');
            } elseif (Str::endsWith($key, '_id')) {
                $operator = '=';
            }
        }

        $this->filterOperator = $operator;
        $this->filterValue = $filterValue;
    }

    /**
     * Add a query on a foreign relationship of the model
     */
    protected function foreign(Builder $query, string $relationName, string $key): void
    {
        $relation = $this->{$relationName}();
        $foreignName = $relation->getQuery()->getQuery()->from;

        $query
            ->select($this->getTable() . '.*')
            ->with($relationName)
            ->leftJoin($foreignName . ' as f', 'f.id', $this->getTable() . '.' . $relation->getForeignKeyName())
            ->where(
                str_replace($relationName, 'f', str_replace('-', '.', $key)),
                $this->filterOperator,
                ($this->filterOperator == '=' ? $this->filterValue : "%{$this->filterValue}%")
            );
    }

    /**
     * Determine if the filter option is the one required
     */
    protected function filterOption(string $condition): bool
    {
        return !empty($this->filterOption) && $this->filterOption === $condition;
    }

    /**
     * Filter on the attributes of an entity
     */
    protected function filterAttributes(Builder $query, string $key): void
    {
        if ($key == 'attribute_value') {
            return;
        }
        $query->joinEntity();

        // No attribute with this name
        if ($this->filterOperator === 'not like') {
            $query
                ->whereRaw('(select count(*) from attributes as att where att.entity_id = e.id and att.name = \''
                    . ($this->filterValue) . '\') = 0');
            return;
        }
        $query
            ->select($this->getTable() . '.*')
            ->leftJoin('attributes as att', function ($join) {
                $join->on('att.entity_id', '=', 'e.id');
            })
            ->where('att.name', $this->filterValue);

        $attributeValue = Arr::get($this->filterParams, 'attribute_value');
        if ($attributeValue === '!') {
            $query
                ->whereRaw('att.value <> ""');
        } elseif ($attributeValue !== '' && $attributeValue !== null) {
            $query
                ->where('att.value', $attributeValue);
        }
    }

    /**
     * Filter on the connections of an entity
     */
    protected function filterConnections(Builder $query, string $key): void
    {
        if ($key == 'connection_target' &&  Arr::get($this->filterParams, 'connection_name')) {
            return;
        }

        $query->joinEntity();

        $query
            ->leftJoin('relations as rel', function ($join) {
                $join->on('rel.owner_id', '=', 'e.id');
            });
        $connectionTarget = Arr::get($this->filterParams, 'connection_target');
        if ($connectionTarget !== '' && $connectionTarget !== null) {
            $query
                ->where('rel.target_id', $connectionTarget);
        }

        $connectionName = Arr::get($this->filterParams, 'connection_name');
        if ($connectionName !== '' && $connectionName !== null) {
            $connectionName = $this->filterValue;
            if ($this->filterOperator != '=') {
                $connectionName = '%' . $this->filterValue . '%';
            }

            $query
                ->where('rel.relation', $this->filterOperator, $connectionName);
        }
    }

    /**
     * General fallback filter for what wasn't cought in specific cases
     */
    protected function filterFallback(Builder $query, string $key): void
    {
        if ($this->filterOption('exclude')) {
            $query->where(function ($subquery) use ($key) {
                return $subquery->where(
                    $this->getTable() . '.' . $key,
                    '!=',
                    $this->filterValue
                )->orWhereNull($this->getTable() . '.' . $key);
            });

            return;
        }
        $searchTerms = explode(';', $this->filterValue);
        $firstTerm = true;
        foreach ($searchTerms as $searchTerm) {
            if (empty($searchTerm) && $searchTerm != '0') {
                continue;
            }
            // If it isn't the first term, we need to re-extract the search operators
            if (!$firstTerm) {
                $this->extractSearchOperator($searchTerm, $key);
                $searchTerm = $this->filterValue;
            }
            $query->where(
                $this->getTable() . '.' . $key,
                $this->filterOperator,
                ($this->filterOperator == '=' ? $this->filterValue : "%{$searchTerm}%")
            );
            $firstTerm = false;
        }
    }

    /**
     * Filter on entities with files
     */
    protected function filterHasFiles(Builder $query, ?string $value = null): void
    {
        $query
            ->joinEntity()
            ->leftJoin('entity_assets', 'entity_assets.entity_id', '=', 'e.id')
            ->where('entity_assets.type_id', \App\Models\EntityAsset::TYPE_FILE);

        if ($value) {
            $query->whereNotNull('entity_assets.id');
        } else {
            $query->whereNull('entity_assets.id');
        }
    }

    /**
     * Filter on entities with or without an uploaded image
     */
    protected function filterHasImage(Builder $query, ?string $value = null): void
    {
        $query->joinEntity();
        if ($value) {
            $query->whereNotNull('e.image_path');
        } else {
            $query->whereNull('e.image_path');
        }
    }

    /**
     * Filter on entities that are or aren't templates
     */
    protected function filterTemplate(Builder $query, ?string $value = null): void
    {
        $query->joinEntity();

        if ($value) {
            $query->where('e.is_template', 1);
        } else {
            $query->where(function ($sub) {
                $sub->whereNull('e.is_template')
                    ->orWhere('e.is_template', '<>', 1);
            });
        }
    }

    /**
     * Filter on entities with posts
     */
    protected function filterHasPosts(Builder $query, ?string $value = null): void
    {
        $query
            ->joinEntity()
            ->leftJoin('posts', 'posts.entity_id', 'e.id');

        if ($value) {
            $query->whereNotNull('posts.id');
        } else {
            $query->whereNull('posts.id');
        }
    }

    /**
     * Filter on entities that are equipped
     */
    protected function filterIsEquipped(Builder $query, ?string $value = null): void
    {
        $query
            ->leftJoin('inventories', 'inventories.item_id', 'items.id');

        if ($value) {
            $query->whereNotNull('inventories.id');
        } else {
            $query->whereNull('inventories.id');
        }
        $query->distinct('items.id');
    }

    /**
     * Filter on entities with attributes
     */
    protected function filterHasAttributes(Builder $query, ?string $value = null): void
    {
        $query
            ->joinEntity()
            ->leftJoin('attributes', 'attributes.entity_id', 'e.id');

        if ($value) {
            $query->whereNotNull('attributes.id');
        } else {
            $query->whereNull('attributes.id');
        }
    }

    /**
     * Filter on characters on multiple races
     */
    protected function filterRaces(Builder $query, null|string|array $value = null): void
    {
        // "none" filter keys is handled later
        if ($this->filterOption('none')) {
            return;
        }
        $query
            ->joinEntity()
        ;

        // Make sure we always have an array
        if (!is_array($value)) {
            $value = [$value];
        }

        if ($this->filterOption('exclude')) {
            $raceIds = [];
            foreach ($value as $v) {
                $raceIds[] = (int) $v;
            }
            $query->whereRaw('(select count(*) from character_race as cr where cr.character_id = ' .
                $this->getTable() . '.id and cr.race_id in (' . implode(', ', $raceIds) . ')) = 0');
            return;
        }

        foreach ($value as $v) {
            $v = (int) $v;
            $query
                ->leftJoin('character_race as cr' . $v, "cr{$v}.character_id", $this->getTable() . '.id')
                ->where("cr{$v}.race_id", $v)
            ;
        }
    }

    /**
     * Filter on characters on multiple locations
     */
    protected function filterLocations(Builder $query, string $value = null, string $key = null): void
    {
        if (method_exists($this, 'scopeLocation')) {
            $query->location($value, $this->getFilterOption());
            return;
        }
        if ($this->filterOption('children')) {
            /** @var Location|null $location */
            $location = Location::find($value);
            if (empty($location)) {
                return;
            }
            $locationIds = $location->descendants->pluck('id')->toArray();
            array_unshift($locationIds, $location->id);
            $query->whereIn($this->getTable() . '.location_id', $locationIds)->distinct();

            return;
        }
        $this->filterFallback($query, $key);
    }

    /**
     * Filter characters on a single race
     */
    protected function filterRace(Builder $query, ?string $value = null): void
    {
        $ids = [$value];
        if ($this->filterOption('exclude')) {
            if (auth()->check() && auth()->user()->isAdmin()) {
                $query->whereRaw('(select count(*) from character_race as cr where cr.character_id = ' .
                    $this->getTable() . '.id and cr.race_id = ' . ((int) $value) . ') = 0');
            } else {
                $query->whereRaw('(select count(*) from character_race as cr where cr.character_id = ' .
                    $this->getTable() . '.id and cr.race_id = ' . ((int) $value) . ' and cr.is_private = 0) = 0');
            }
            return;

        } elseif ($this->filterOption('children')) {
            /** @var Race|null $race */
            $race = Race::find($value);
            if (!empty($race)) {
                $raceIds = $race->descendants->pluck('id')->toArray();
                array_push($raceIds, $race->id);
                $ids = $raceIds;
            }
        }
        $query
            ->select($this->getTable() . '.*')
            ->leftJoin('character_race as cr', function ($join) {
                $join->on('cr.character_id', '=', $this->getTable() . '.id');
            })->whereIn('cr.race_id', $ids);

        if (auth()->guest() || !auth()->user()->isAdmin()) {
            $query->where('cr.is_private', false);
        }
        $query->distinct();
    }

    /**
     * Filter characters on a single family
     */
    protected function filterFamily(Builder $query, ?string $value = null): void
    {
        $ids = [$value];
        if ($this->filterOption('exclude')) {
            $query->whereRaw('(select count(*) from character_family as cf where cf.character_id = ' .
                $this->getTable() . '.id and cf.family_id = ' . ((int) $value)
                . ' ' . /*$this->subPrivacy('and cf.is_private') .*/ ') = 0');
            return;

        } elseif ($this->filterOption('children')) {
            /** @var Family|null $family */
            $family = Family::find($value);
            if (!empty($family)) {
                $familyIds = $family->descendants->pluck('id')->toArray();
                array_push($familyIds, $family->id);
                $ids = $familyIds;
            }
        }
        $query
            ->select($this->getTable() . '.*')
            ->leftJoin('character_family as cf', function ($join) {
                $join->on('cf.character_id', '=', $this->getTable() . '.id');
            })->whereIn('cf.family_id', $ids);

        /*if (auth()->guest() || !auth()->user()->isAdmin()) {
            $query->where('cf.is_private', false);
        }*/

        $query->distinct();
    }

    /**
     * Filter on entities with specific tags
     */
    protected function filterTags(Builder $query, null|string|array $value = null): void
    {
        // "none" filter tags is handled later (because this won't be called if the tags field is empty)
        if ($this->filterOption('none')) {
            return;
        }
        $query
            ->joinEntity()
        ;

        // Make sure we always have an array
        if (!is_array($value)) {
            $value = [$value];
        }

        if ($this->filterOption('exclude')) {
            $tagIds = [];
            foreach ($value as $v) {
                $tagIds[] = (int) $v;
            }
            //$query->leftJoin('entity_tags as et_tags', "et_tags.entity_id", 'e.id')
            $query->whereRaw('(
                select count(*) from entity_tags as et
                where et.entity_id = e.id and et.tag_id in (' . implode(', ', $tagIds) . ')
            ) = 0');

            return;
        }

        foreach ($value as $v) {
            if (!is_numeric($v)) {
                continue;
            }
            $v = (int) $v;
            $query
                ->leftJoin('entity_tags as et' . $v, "et{$v}.entity_id", 'e.id')
                ->where("et{$v}.tag_id", $v)
            ;
        }
    }

    /**
     * Filter on models at or between given real dates
     */
    protected function filterDateRange(Builder $query, string $key, array $params = []): void
    {
        // Don't apply twice if both fields are set
        if ($key === 'date_end' && !empty($params['date_start'])) {
            return;
        }
        $start = Arr::get($params, 'date_start');
        $end = Arr::get($params, 'date_end');

        if ($start && $end) {
            $query->whereBetween('date', [$start, $end]);
        } elseif ($end) {
            $query->whereDate('date', '=', $end);
        } else {
            $query->whereDate('date', '=', $start);
        }
    }

    /**
     * Filter for elements with a specific member (character) in them
     */
    protected function filterMember(Builder $query, ?string $value = null): void
    {
        $filter = $this->getFilterOption();
        $query->member($value, $filter);
    }

    /**
     * Filter on entities that have one of the targets as "none" selected
     */
    protected function filterNoneOptions(Builder $query, string $key, array $fields = []): void
    {
        $key = Str::beforeLast($key, '_option');
        // Validate the key is a filter
        if (!in_array($key, $fields)) {
            return;
        }
        // Left join shenanigans
        if (!in_array($key, ['race_id', 'family_id', 'tags', 'quest_element_id', 'member_id'])) {
            if ($key === 'location_id' && method_exists($this, 'scopeLocation')) {
                $query->location(null, FilterOption::NONE);
            } else {
                $query->whereNull($this->getTable() . '.' . $key);
            }
        } elseif ($key === 'tags') {
            $query
                ->joinEntity()
                ->leftJoin('entity_tags as no_tags', 'no_tags.entity_id', 'e.id')
                ->whereNull('no_tags.tag_id');
        } elseif ($key === 'race_id') {
            $query
                ->select($this->getTable() . '.*')
                ->leftJoin('character_race as cr2', function ($join) {
                    $join->on('cr2.character_id', '=', $this->getTable() . '.id');
                })
                ->where('cr2.race_id', null);
        } elseif ($key === 'family_id') {
            $query
                ->select($this->getTable() . '.*')
                ->leftJoin('character_family as cf2', function ($join) {
                    $join->on('cf2.character_id', '=', $this->getTable() . '.id');
                })
                ->where('cf2.family_id', null);
        } elseif ($key === 'quest_element_id') {
            $query->element(null, FilterOption::NONE);
        } elseif ($key === 'member_id') {
            $query->member(null, FilterOption::NONE);
        }
    }

    /**
     * Get the filter option enum
     */
    protected function getFilterOption(): FilterOption
    {
        match ($this->filterOption) {
            'exclude' => $filter = FilterOption::EXCLUDE,
            'none' => $filter = FilterOption::NONE,
            'children' => $filter = FilterOption::CHILDREN,
            default => $filter = FilterOption::INCLUDE,
        };
        return $filter;
    }

    protected function filterParent(Builder $query): void
    {
        $query->where($this->getTable() . '.' . $this->getParentKeyName(), $this->filterValue);
    }

    protected function explicitFilters(): array
    {
        if (property_exists($this, 'explicitFilters')) {
            return $this->explicitFilters;
        }
        return [];
    }

    protected function subPrivacy(string $field): string|null
    {
        // Campaign admins don't have private data hidden from them
        if (auth()->check() && auth()->user()->isAdmin()) {
            return null;
        }

        return ' ' . $field . ' = 0';
    }
}
