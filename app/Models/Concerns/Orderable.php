<?php

namespace App\Models\Concerns;

use App\Enums\EntityEventTypes;
use App\Models\Entity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * @method static self|Builder order(array|null $data)
 */
trait Orderable
{
    public function scopeOrder(Builder $query, ?array $data)
    {
        // Default values can be defined on the model, or default
        $field = $this->defaultOrderField ?: 'name';
        $direction = $this->defaultOrderDirection ?: 'asc';

        if (! empty($data) && auth()->check()) {
            foreach ($data as $key => $value) {
                $field = $key;
                $direction = $value;
            }
        }

        // Calendar dates are handled differently since we have three fields.
        // However, we should do a left join instead
        if ($field === 'calendar_date') {
            return $query
                ->joinEntity()
                ->leftJoin('reminders as cd', function ($on) {
                    return $on->on('cd.remindable_id', 'e.id')
                        ->on('cd.remindable_type', '=', DB::raw("'" . addslashes(Entity::class) . "'"))
                        ->where('cd.type_id', EntityEventTypes::calendarDate);
                })
                ->orderBy('cd.year', $direction)
                ->orderBy('cd.month', $direction)
                ->orderBy('cd.day', $direction);
        } elseif ($field === 'type') {
            return $query
                ->joinEntity()
                ->orderBy('e.type', $direction);
        } elseif ($field === 'locations') {
            return $query
                ->joinEntity()
                ->leftJoin('entity_locations', 'entity_locations.entity_id', '=', 'e.id')
                ->leftJoin('locations', 'locations.id', '=', 'entity_locations.location_id')
                ->orderBy('locations.name', $direction);
        }
        if (! empty($field)) {
            $segments = explode('.', $field);
            if (count($segments) > 1) {
                $relationName = $segments[0];

                /** @var BelongsTo $relation */
                $relation = $this->{$relationName}();
                $foreignName = $relation->getQuery()->getQuery()->from;

                return $query
                    ->with($relationName)
                    ->leftJoin(
                        $foreignName . ' as orderable_j',
                        'orderable_j.id',
                        $this->getTable() . '.' . $relation->getForeignKeyName()
                    )
                    ->orderBy(str_replace($relationName, 'orderable_j', $field), $direction);
            } else {
                // Order by related table? Yeah that's fun.
                // While this would be possible, this would mean injecting the acl/permission system
                // just for an order by, which seems quite overkill.
                // A better solution might present itself during a future rewrite of the acl engine.
                //                if (substr($field, 0, 6) == 'count(') {
                //                    $relationName = preg_replace('/count\((.*)\)/si', '$1', $field);
                //                    $relation = $this->{$relationName}();
                //                    $foreignName = $relation->getQuery()->getQuery()->from;
                //
                //                    return $query
                //                        ->orderByRaw('(select count(*) from ' . $foreignName . ' where ' .
                // $relation->getForeignKeyName() . ' = ' . $this->getTable() . '.' . $this->primaryKey . ') ' . $direction);
                //                }

                // If the field has a casting
                if (property_exists($this, 'orderCasting') && ! empty($this->orderCasting[$field])) {
                    return $query->orderByRaw(
                        'cast(' . $this->getTable() . '.' . $field . ' as ' . $this->orderCasting[$field] . ')'
                        . $direction
                    );
                }

                return $query->orderBy($this->getTable() . '.' . $field, $direction);
            }
        }

        return $query;
    }
}
