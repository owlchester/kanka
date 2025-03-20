<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static self|Builder year(int $year)
 * @method static self|Builder month(int $month)
 * @method static self|Builder dated(int $calendarID, int $year, int $month, int $year)
 */
trait CalendarWeatherScopes
{
    /**
     * @return Builder
     */
    public function scopeYear(Builder $builder, int $year)
    {
        return $builder->where('year', $year);
    }

    /**
     * @return Builder
     */
    public function scopeMonth(Builder $builder, int $month)
    {
        return $builder->where('month', $month);
    }

    public function scopeDated(Builder $builder, int $calendarId, int $year, int $month, int $day)
    {
        // @phpstan-ignore-next-line
        return $builder
            ->where('calendar_id', $calendarId)
            ->year($year)
            ->month($month)
            ->where('day', $day);
    }
}
