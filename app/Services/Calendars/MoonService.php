<?php

namespace App\Services\Calendars;

use App\Traits\CalendarAware;
use Illuminate\Support\Arr;

class MoonService
{
    use CalendarAware;

    protected array $moons = [];

    public function has(string $day): bool
    {
        return isset($this->moons[$day]);
    }

    public function get(string $day): array
    {
        return $this->moons[$day] ?? [];
    }

    public function build(int $totalDays, int $daysInAYear): void
    {
        foreach ($this->calendar->moons() as $moon) {
            $fullmoon = $moon['fullmoon'];
            // Let's figure out how many full moons occurred until now
            $numberOfFullMoons = $totalDays / $fullmoon;

            // When was the last full moon?
            $lastFullMoon = floor($numberOfFullMoons) * $fullmoon;

            // Use that to see how many days it's been
            $daysSinceLastFullMoon = round($totalDays - $lastFullMoon, 2);

            // Next full moon? If it's 0, we want it today.
            $nextFullMoon = (1 + $moon['offset']) + ($fullmoon - ($daysSinceLastFullMoon == 0 ? $fullmoon : $daysSinceLastFullMoon));

            // Previous cycles. Twice because sometimes the first full moon appears at the end of a long month, so
            // we need to fill up the month as much as we can.
            // With a big enough offset and fullmoon cycle, the user can end up with no moon on their first month of
            // the first year?
            $maxCycles = max(2, 3);
            for ($cycles = 1; $cycles <= $maxCycles; $cycles++) {
                $this->addPhases($nextFullMoon - ($moon['fullmoon'] * $cycles), $moon);
            }

            // Current cycles
            $this->addPhases($nextFullMoon, $moon);

            // Now the full moon will appear several times on this month/year.
            $fullMoonsPerYear = ceil($daysInAYear / $fullmoon);
            for ($i = 0; $i < $fullMoonsPerYear; $i++) {
                $nextFullMoon += $fullmoon;
                $this->addPhases($nextFullMoon, $moon);
            }
        }
    }

    protected function addPhases(float $start, array $moon): void
    {
        // Full & New Moon
        $this->addPhase($start, $moon, 'full', 'far fa-circle');
        $newMoon = $start + ($moon['fullmoon'] / 2);
        $this->addPhase($newMoon, $moon, 'new', 'fa-solid fa-circle');

        if ($moon['fullmoon'] <= 10) {
            return;
        }
        // Cycle is long enough for more phases to be displayed
        $quarterMonth = $moon['fullmoon'] / 4;
        $this->addPhase($newMoon - $quarterMonth, $moon, 'last_quarter', 'fa-solid fa-circle-half-stroke fa-flip-horizontal');
        $this->addPhase($newMoon + $quarterMonth, $moon, '1first_quarter', 'fa-solid fa-circle-half-stroke');
    }

    protected function addPhase(float $nextFullMoon, array $moon, string $type = 'full', string $class = 'fa-regular fa-circle'): void
    {
        // Moons can be float so we "floor" them
        $nextFullMoon = floor($nextFullMoon);

        // If the next full moon is before year 0... What?
        if ($nextFullMoon < 0) {
            // return;
        }
        if (! isset($this->moons[$nextFullMoon])) {
            $this->moons[$nextFullMoon] = [];
        }
        $this->moons[$nextFullMoon][] = [
            'name' => $moon['name'],
            'type' => $type,
            'class' => $class,
            'colour' => $this->colour(Arr::get($moon, 'colour', 'grey')),
            'id' => Arr::get($moon, 'id', null),
        ];
    }

    protected function colour(string $colour): string
    {
        switch ($colour) {
            case 'aqua':
                return 'blue-500';
            case 'black':
                return 'black';
            case 'brown':
                return 'orange-900';
                /*case 'green':
                    return 'green-500';*/
            case 'light-blue':
                return 'blue-300';
            case 'maroon':
                return 'pink-800';
            case 'navy':
                return 'blue-900';
                /*case 'orange':
                    return 'orange-500';
                case 'pink':
                    return 'pink-500';
                case 'purple':
                    return 'purple-500';
                case 'red':
                    return 'red-500';
                case 'teal':
                    return 'teal-500';
                case 'yellow':
                    return 'yellow-500';*/
            case 'grey':
                return 'gray-500';
        }

        return $colour . '-500';
    }
}
