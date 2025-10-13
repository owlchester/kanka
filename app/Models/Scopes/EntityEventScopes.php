<?php

namespace App\Models\Scopes;

use App\Enums\EntityEventTypes;
use App\Models\Calendar;
use Illuminate\Database\Eloquent\Builder;

trait EntityEventScopes
{
    /**
     * All events before the current calendar's date
     */
    public function scopeBefore(Builder $query, Calendar $calendar): Builder
    {
        $year = $calendar->currentDate('year');
        $month = $calendar->currentDate('month');
        $day = $calendar->currentDate('date');

        return $query->where('year', '<', $year)
            ->orWhere(function ($sub) use ($year, $month) {
                $sub->where('year', '=', $year)
                    ->where('month', '<', $month);
            })
            ->orWhere(function ($sub) use ($year, $month, $day) {
                $sub->where('year', '=', $year)
                    ->where('month', '=', $month)
                    ->where('day', '<=', $day);
            });
    }

    /**
     * All events today and after today
     */
    public function scopeAfter(Builder $query, Calendar $calendar): Builder
    {
        $year = $calendar->currentDate('year');
        $month = $calendar->currentDate('month');
        $day = $calendar->currentDate('date');

        return $query->where('year', '>', $year)
            ->orWhere(function ($sub) use ($year, $month) {
                $sub->where('year', '=', $year)
                    ->where('month', '>', $month);
            })
            ->orWhere(function ($sub) use ($year, $month, $day) {
                $sub->where('year', '=', $year)
                    ->where('month', '=', $month)
                    ->where('day', '>=', $day);
            });
    }

    /**
     * Sort order for the datagrid page
     */
    public function scopeCustomSortDate(Builder $query, ?string $order = null): Builder
    {
        return $query
            ->orderBy('year', $order)
            ->orderBy('month', $order)
            ->orderBy('day', $order);
    }

    public function scopeEntity(Builder $query, int $entity_id): Builder
    {
        return $query->where('entity_id', $entity_id);
    }

    public function scopeCalendar(Builder $query, int $calendar_id): Builder
    {
        return $query->where('calendar_id', $calendar_id);
    }

    public function scopeCalendarDate(Builder $query): Builder
    {
        return $query->where('type_id', EntityEventTypes::CALENDAR_DATE->values);
    }
}
