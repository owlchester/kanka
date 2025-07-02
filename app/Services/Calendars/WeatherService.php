<?php

namespace App\Services\Calendars;

use App\Models\CalendarWeather;
use App\Traits\CalendarAware;

class WeatherService
{
    use CalendarAware;

    /** @var CalendarWeather[] */
    protected array $effects = [];

    protected int $currentYear;

    public function currentYear(int $currentYear): self
    {
        $this->currentYear = $currentYear;

        return $this;
    }

    public function has(string $day): bool
    {
        return isset($this->effects[$day]);
    }

    public function get(string $day): CalendarWeather
    {
        return $this->effects[$day];
    }

    public function build(): void
    {
        // First build parent weather, and override with local weather
        if ($this->calendar->calendar) {
            $weathers = $this->calendar->calendar->calendarWeather()->year($this->currentYear)->get();

            /** @var CalendarWeather $weather */
            foreach ($weathers as $weather) {
                $this->effects[$weather->year . '-' . $weather->month . '-' . $weather->day] = $weather;
            }
        }

        $weathers = $this->calendar->calendarWeather()->year($this->currentYear)->get();

        /** @var CalendarWeather $weather */
        foreach ($weathers as $weather) {
            $this->effects[$weather->year . '-' . $weather->month . '-' . $weather->day] = $weather;
        }
    }
}
