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

            $options[$name] = [];
            foreach (array_keys(MoonPhase::PHASES) as $phase) {
                $suffix = MoonPhase::recurrenceSuffix($phase);
                $label = $phase === 'full' ? 'fullmoon' : ($phase === 'new' ? 'newmoon' : $phase);
                $options[$name][$moon['id'] . '_' . $suffix] = __('calendars.options.events.recurring_periodicity.' . $label);
            }
        }

        return $options;
    }

    /** @return array<string, string> */
    public function forApi(Calendar $calendar): array
    {
        $options = $this->baseOptions();

        foreach ($calendar->moons() as $moon) {
            $name = (string) ($moon['name'] ?? '');
            foreach (array_keys(MoonPhase::PHASES) as $phase) {
                $suffix = MoonPhase::recurrenceSuffix($phase);
                $label = $phase === 'full' ? 'fullmoon_name' : ($phase === 'new' ? 'newmoon_name' : $phase . '_name');
                $options[$moon['id'] . '_' . $suffix] = __('calendars.options.events.recurring_periodicity.' . $label, ['moon' => $name]);
            }
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
