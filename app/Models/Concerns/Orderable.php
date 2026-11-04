<?php

namespace App\Models\Concerns;

use App\Enums\EntityEventTypes;
use App\Models\Entity;
use App\Models\MiscModel;
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
        if ($this instanceof MiscModel && $query->getQuery()->columns === null) {
            $query->select($this->getTable() . '.*');
        }

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
        } elseif (in_array($field, ['name', 'is_private', 'updated_at'], true) && method_exists($this, 'scopeJoinEntity')) {
            return $query
                ->joinEntity()
                ->orderBy('e.' . $field, $direction);
        } elseif ($field === 'type' && method_exists($this, 'scopeJoinEntity')) {
            return $query
                ->joinEntity()
                ->orderBy('e.type', $direction);
        } elseif ($field === 'locations' && method_exists($this, 'scopeJoinEntity')) {
            return $query
                ->joinEntity()
                ->leftJoin('entity_locations', 'entity_locations.entity_id', '=', 'e.id')
                ->leftJoin('locations', 'locations.id', '=', 'entity_locations.location_id')
                ->leftJoin('entities as location_order_entities', function ($join) {
                    $join->on('location_order_entities.entity_id', '=', 'locations.id')
                        ->where('location_order_entities.type_id', config('entities.ids.location'));
                })
                ->orderBy('location_order_entities.name', $direction);
        }
        if (! empty($field)) {
            $segments = explode('.', $field);
            if (count($segments) > 1) {
                $relationName = $segments[0];

                /** @var BelongsTo $relation */
                $relation = $this->{$relationName}();
                $foreignName = $relation->getQuery()->getQuery()->from;

                if ($segments[1] === 'name' && method_exists($relation->getRelated(), 'entityTypeId')) {
                    return $query
                        ->leftJoin($foreignName . ' as orderable_j', 'orderable_j.id', $this->getTable() . '.' . $relation->getForeignKeyName())
                        ->leftJoin('entities as orderable_entity', function ($join) use ($relation) {
                            $join->on('orderable_entity.entity_id', '=', 'orderable_j.id')
                                ->where('orderable_entity.type_id', $relation->getRelated()->entityTypeId());
                        })
                        ->orderBy('orderable_entity.name', $direction);
                }

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
