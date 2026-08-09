<?php

namespace App\Services\Calendars;

use App\Models\Calendar;

final class RecurrenceOptionsService
{
    /** @return array<string, string|array<string, string>> */
    public function forSelect(Calendar $calendar): array
    {
        $options = $this->baseOptions();
        $unnamed = 0;

        foreach ($calendar->moons() as $moon) {
            $name = (string) ($moon['name'] ?? '');
            if ($name === '') {
                $unnamed++;
                $name = __('calendars.options.events.recurring_periodicity.unnamed_moon', ['number' => $unnamed]);
            }

            $options[$name] = [
                $moon['id'] . '_f' => __('calendars.options.events.recurring_periodicity.fullmoon'),
                $moon['id'] . '_n' => __('calendars.options.events.recurring_periodicity.newmoon'),
            ];
        }

        return $options;
    }

    /** @return array<string, string> */
    public function forApi(Calendar $calendar): array
    {
        $options = $this->baseOptions();

        foreach ($calendar->moons() as $moon) {
            $name = (string) ($moon['name'] ?? '');
            $options[$moon['id'] . '_f'] = __('calendars.options.events.recurring_periodicity.fullmoon_name', ['moon' => $name]);
            $options[$moon['id'] . '_n'] = __('calendars.options.events.recurring_periodicity.newmoon_name', ['moon' => $name]);
        }

        return $options;
    }

    /** @return array<string, string> */
    private function baseOptions(): array
    {
        return [
            '' => __('calendars.options.events.recurring_periodicity.none'),
            'month' => __('calendars.options.events.recurring_periodicity.month'),
            'year' => __('calendars.options.events.recurring_periodicity.year'),
        ];
    }
}
