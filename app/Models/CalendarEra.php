<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CalendarEra
 *
 * @property int $id
 * @property int $calendar_id
 * @property string $name
 * @property ?string $description
 * @property ?string $colour
 * @property int $visibility_id
 * @property ?int $start_day
 * @property ?int $start_month
 * @property int $start_year
 * @property ?int $end_day
 * @property ?int $end_month
 * @property ?int $end_year
 * @property bool $show_era_dates
 * @property Calendar $calendar
 */
class CalendarEra extends Model
{
    use Blameable;
    use HasVisibility;
    use Sanitizable;
    use SortableTrait;

    public $table = 'calendar_eras';

    public $fillable = [
        'calendar_id',
        'name',
        'description',
        'colour',
        'visibility_id',
        'start_day',
        'start_month',
        'start_year',
        'end_day',
        'end_month',
        'end_year',
        'show_era_dates',
    ];

    protected array $sortable = [
        'name',
        'start_year',
        'end_year',
    ];

    protected array $sanitizable = [
        'name',
        'description',
    ];

    /**
     * @return BelongsTo<Calendar, $this>
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    public function startDay(): int
    {
        return $this->start_day ?? 1;
    }

    public function startMonth(): int
    {
        return $this->start_month ?? 1;
    }

    public function endDay(): int
    {
        return $this->end_day ?? 1;
    }

    public function endMonth(): int
    {
        return $this->end_month ?? 1;
    }

    /**
     * Check if the given date falls within this era
     */
    public function containsDate(int $year, int $month, int $day): bool
    {
        $startMonth = $this->startMonth();
        $startDay = $this->startDay();

        // Check if date is after or on the start date
        if ($year < $this->start_year) {
            return false;
        }
        if ($year == $this->start_year) {
            if ($month < $startMonth) {
                return false;
            }
            if ($month == $startMonth && $day < $startDay) {
                return false;
            }
        }

        // If no end date, era is ongoing
        if (! $this->hasEndDate()) {
            return true;
        }

        $endMonth = $this->endMonth();
        $endDay = $this->endDay();

        // Check if date is before or on the end date
        if ($year > $this->end_year) {
            return false;
        }
        if ($year == $this->end_year) {
            if ($month > $endMonth) {
                return false;
            }
            if ($month == $endMonth && $day > $endDay) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate the era year for a given calendar year
     */
    public function eraYear(int $year): int
    {
        return abs($year - $this->start_year) + 1;
    }

    public function hasEndDate(): bool
    {
        return $this->end_year !== null;
    }

    /**
     * Functions for the datagrid
     */
    public function url(string $where): string
    {
        return 'calendars.calendar_eras.' . $where;
    }

    public function routeParams(array $options = []): array
    {
        return $options + ['calendar' => $this->calendar_id, 'calendar_era' => $this->id];
    }

    public function getLink(): string
    {
        $campaign = CampaignLocalization::getCampaign();

        return route('calendars.calendar_eras.edit', [$campaign, 'calendar' => $this->calendar_id, $this->id]);
    }

    public function hasEntity(): bool
    {
        return false;
    }
}
