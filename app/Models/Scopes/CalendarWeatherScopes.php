<?php
/**
 * Description of
 *
 * @author Ilestis
 * 20/01/2020
 */

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait CalendarWeatherScopes
{
    /**
     * @param Builder $builder
     * @param int $year
     * @return Builder
     */
    public function scopeYear(Builder $builder, int $year)
    {
        return $builder->where('year', $year);
    }

    /**
     * @param Builder $builder
     * @param int $month
     * @return Builder
     */
    public function scopeMonth(Builder $builder, int $month)
    {
        return $builder->where('month', $month);
    }

    /**
     * @param Builder $builder
     * @param int $year
     * @param int $month
     * @param int $day
     * @return mixed
     */
    public function scopeDated(Builder $builder, int $calendarId, int $year, int $month, int $day)
    {
        return $builder
            ->where('calendar_id', $calendarId)
            ->year($year)
            ->month($month)
            ->where('day', $day);
    }
}
