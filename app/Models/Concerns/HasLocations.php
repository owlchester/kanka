<?php

namespace App\Models\Concerns;

use App\Enums\FilterOption;
use App\Models\Location;
use App\Observers\LocationsObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Collection|Location[] $locations
 */
trait HasLocations
{
    //    protected string $locationPivot = '';
    //    protected string $locationPivotKey = '';

    public static function bootHasLocations(): void
    {
        static::observe(LocationsObserver::class);
    }

    /**
     * Model have multiple locations through a pivot table
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Location', $this->getLocationPivotTableName())
            ->with('entity');
    }

    protected function getLocationPivotTableName(): string
    {
        return $this->locationPivot;
    }

    protected function getLocationPivotKey(): string
    {
        return $this->locationPivotKey;
    }

    /**
     * Filter on models tied to a specific location or its descendants
     */
    public function scopeLocation(Builder $query, ?int $location, FilterOption $filter): Builder
    {
        if ($filter === FilterOption::NONE) {
            if (! empty($location)) {
                return $query;
            }

            return $query
                ->whereRaw('(select count(*) from ' . $this->getLocationPivotTableName() . ' as lp where lp.' . $this->getLocationPivotKey() . ' = ' .
                    $this->getTable() . '.id and lp.location_id = ' . ((int) $location) . ') = 0');
        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from ' . $this->getLocationPivotTableName() . ' as lp where lp.' . $this->getLocationPivotKey() . ' = ' .
                    $this->getTable() . '.id and lp.location_id = ' . ((int) $location) . ') = 0');
        }

        $ids = [$location];
        if ($filter === FilterOption::CHILDREN) {
            /** @var ?Location $model */
            $model = Location::find($location);
            if (! empty($model)) {
                $ids = [...$model->descendants->pluck('id')->toArray(), $model->id];
            }
        }

        return $query
            ->select($this->getTable() . '.*')
            ->leftJoin($this->getLocationPivotTableName() . ' as lp', function ($join) {
                $join->on('lp.' . $this->getLocationPivotKey(), '=', $this->getTable() . '.id');
            })
            ->whereIn('lp.location_id', $ids)->distinct();
    }
}
