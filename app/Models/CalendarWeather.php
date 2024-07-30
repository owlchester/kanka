<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\Sanitizable;
use App\Models\Scopes\CalendarWeatherScopes;
use App\Traits\VisibilityIDTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CalendarWeather
 * @package App\Models
 *
 * @property int $id
 * @property int $calendar_id
 * @property string $weather
 * @property string $temperature
 * @property string $precipitation
 * @property string $wind
 * @property string $effect
 * @property int $year
 * @property int $month
 * @property int $day
 * @property string $name
 * @property Calendar $calendar
 */
class CalendarWeather extends Model
{
    use Blameable;
    use CalendarWeatherScopes;
    use Sanitizable;
    use VisibilityIDTrait;

    public $table = 'calendar_weather';

    public $fillable = [
        'calendar_id',
        'weather',
        'temperature',
        'precipitation',
        'wind',
        'effect',
        'day',
        'month',
        'year',
        'visibility_id',
        'name',
    ];

    protected array $sanitizable = [
        'weather',
        'temperature',
        'precipitation',
        'wind',
        'effect',
        'name',
    ];

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    public function tooltip(): string
    {
        return
            (!empty($this->temperature) ? __('calendars/weather.fields.temperature') . ': ' . e($this->temperature) . "<br />\n" : null) .
            (!empty($this->precipitation) ? __('calendars/weather.fields.precipitation') . ': ' . e($this->precipitation) . "<br />\n" : null) .
            (!empty($this->wind) ? __('calendars/weather.fields.wind') . ': ' . e($this->wind) . "<br />\n" : null) .
            (!empty($this->effect) ? __('calendars/weather.fields.effect') . ': ' . e($this->effect) . "<br />\n" : null)
        ;
    }

    public function weatherName(): string
    {
        if (!empty($this->name)) {
            return $this->name;
        }

        return __('calendars/weather.options.weather.' . $this->weather);
    }
}
