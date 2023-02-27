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
 * @method static self|Builder filter(array $params = null)
 */
trait HasFilters
{
    /**
     * Explicit fields for filtering.
     * Ex. ['sex']
     * @var array
     */
    protected $explicitFilters = [];

    /**
     * @var bool If the entity table was already joined or not
     */
    protected $joinedEntity = false;

    protected string $key;
    protected string|array|null $filterValue;

    /** @var string|null Some filters have a fellow _option field that can define more in detail what is needed */
    protected string|null $filterOption;

    /** @var string The operator for the SQL search. For example <>, %%, %{term}, etc */
    protected string $filterOperator;

    protected array $filterParams = [];

    /**
     * Get all available filterable columns of the entity. Merge the custom
     * with the default ones (if not overwritten)
     * @return array
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
        ];
    }


    /**
     * @param Builder $query
     * @param array $params
     * @return Builder
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
                if (in_array($key, $this->explicitFilters)) {
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
                    $query = $this->joinEntity($query);
                    $query
                        ->leftJoin('entity_tags as et', 'et.entity_id', 'e.id')
                        ->where('et.tag_id', $value);
                } elseif (in_array($key, ['attribute_value', 'attribute_name'])) {
                    $this->filterAttributes($query, $key);
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
                } elseif ($key == 'has_attributes') {
                    $this->filterHasAttributes($query, $value);
                } elseif ($key == 'has_entity_files') {
                    $this->filterHasFiles($query, $value);
                } elseif (in_array($key, ['created_by', 'updated_by'])) {
                    $query = $this->joinEntity($query);
                    $query->where('e.' . $key, (int) $value);
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
     * @param string $key
     * @return void
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
     * Add a left join on the entity to the query. Only do this once
     * @param Builder $query
     * @return Builder
     */
    protected function joinEntity(Builder $query): Builder
    {
        if ($this->joinedEntity) {
            return $query;
        }

        $this->joinedEntity = true;

        // @phpstan-ignore-next-line
        return $query
            ->distinct()
            ->leftJoin('entities as e', function ($join) {
                $join->on('e.entity_id', '=', $this->getTable() . '.id');
                // @phpstan-ignore-next-line
                $join->where('e.type_id', '=', $this->entityTypeID())
                    ->whereRaw('e.campaign_id = ' . $this->getTable() . '.campaign_id');
            })
            ->groupBy($this->getTable() . '.id')
        ;
    }

    /**
     * Add a query on a foreign relationship of the model
     * @param Builder $query
     * @param string $relationName
     * @param string $key
     * @return void
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
     * @param string $condition
     * @return bool
     */
    protected function filterOption(string $condition): bool
    {
        return !empty($this->filterOption) && $this->filterOption === $condition;
    }

    /**
     * Filter on the attributes of an entity
     * @param Builder $query
     * @param string $key
     * @return void
     */
    protected function filterAttributes(Builder $query, string $key): void
    {
        if ($key == 'attribute_value') {
            return;
        }
        $query = $this->joinEntity($query);

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
     * General fallback filter for what wasn't cought in specific cases
     * @param Builder $query
     * @param string $key
     * @return void
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
     * @param Builder $query
     * @param string|null $value
     * @return void
     */
    protected function filterHasFiles(Builder $query, string $value = null): void
    {
        $query = $this->joinEntity($query);
        $query->leftJoin('entity_assets', 'entity_assets.entity_id', '=', 'e.id')
            ->where('entity_assets.type_id', \App\Models\EntityAsset::TYPE_FILE);

        if ($value) {
            $query->whereNotNull('entity_assets.id');
        } else {
            $query->whereNull('entity_assets.id');
        }
    }

    /**
     * Filter on entities with or without an uploaded image
     * @param Builder $query
     * @param string|null $value
     * @return void
     */
    protected function filterHasImage(Builder $query, string $value = null): void
    {
        if ($value) {
            $query->whereNotNull($this->getTable() . '.image');
        } else {
            $query->whereNull($this->getTable() . '.image');
        }
    }

    /**
     * Filter on entities that are or aren't templates
     * @param Builder $query
     * @param string|null $value
     * @return void
     */
    protected function filterTemplate(Builder $query, string $value = null): void
    {
        $query = $this->joinEntity($query);

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
     * @param Builder $query
     * @param string|null $value
     * @return void
     */
    protected function filterHasPosts(Builder $query, string $value = null): void
    {
        $query = $this->joinEntity($query);
        $query->leftJoin('entity_notes', 'entity_notes.entity_id', 'e.id');

        if ($value) {
            $query->whereNotNull('entity_notes.id');
        } else {
            $query->whereNull('entity_notes.id');
        }
    }

    /**
     * Filter on entities with attributes
     * @param Builder $query
     * @param string|null $value
     * @return void
     */
    protected function filterHasAttributes(Builder $query, string $value = null): void
    {
        $query = $this->joinEntity($query);
        $query->leftJoin('attributes', 'attributes.entity_id', 'e.id');

        if ($value) {
            $query->whereNotNull('attributes.id');
        } else {
            $query->whereNull('attributes.id');
        }
    }

    /**
     * Filter on characters on multiple races
     * @param Builder $query
     * @param string|array|null $value
     * @return void
     */
    protected function filterRaces(Builder $query, string|array $value = null): void
    {
        // "none" filter keys is handled later
        if ($this->filterOption('none')) {
            return;
        }
        $query = $this->joinEntity($query);

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
     * @param Builder $query
     * @param string|null $value
     * @param string|null $key
     * @return void
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
     * @param Builder $query
     * @param string|null $value
     * @return void
     */
    protected function filterRace(Builder $query, string $value = null): void
    {
        $ids = [$value];
        if ($this->filterOption('exclude')) {
            $query->whereRaw('(select count(*) from character_race as cr where cr.character_id = ' .
                $this->getTable() . '.id and cr.race_id = ' . ((int) $value) . ') = 0');
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
            })->whereIn('cr.race_id', $ids)->distinct();
    }

    /**
     * Filter characters on a single family
     * @param Builder $query
     * @param string|null $value
     * @return void
     */
    protected function filterFamily(Builder $query, string $value = null): void
    {
        $ids = [$value];
        if ($this->filterOption('exclude')) {
            $query->whereRaw('(select count(*) from character_family as cf where cf.character_id = ' .
                $this->getTable() . '.id and cf.family_id = ' . ((int) $value) . ') = 0');
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
            })->whereIn('cf.family_id', $ids)->distinct();
    }

    /**
     * Filter on entities with specific tags
     * @param Builder $query
     * @param string|array|null $value
     * @return void
     */
    protected function filterTags(Builder $query, string|array $value = null): void
    {
        // "none" filter tags is handled later (because this won't be called if the tags field is empty)
        if ($this->filterOption('none')) {
            return;
        }
        $query = $this->joinEntity($query);

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
     * @param Builder $query
     * @param string $key
     * @param array $params
     * @return void
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
     * @param Builder $query
     * @param string|null $value
     * @return void
     */
    protected function filterMember(Builder $query, string $value = null): void
    {
        $filter = $this->getFilterOption();
        $query->member($value, $filter);
    }

    /**
     * Filter on entities that have one of the targets as "none" selected
     * @param Builder $query
     * @param string $key
     * @param array $fields
     * @return void
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
            $query = $this->joinEntity($query);
            $query
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
     * @return FilterOption
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
}
