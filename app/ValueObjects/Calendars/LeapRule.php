<?php

namespace App\ValueObjects\Calendars;

use InvalidArgumentException;

final readonly class LeapRule
{
    public function __construct(
        public int $amount,
        public int $month,
        public int $interval,
        public int $startYear,
    ) {
        if ($this->amount < 0 || $this->month < 1 || $this->interval < 1) {
            throw new InvalidArgumentException('Invalid calendar leap rule.');
        }
    }

    public function appliesTo(int $year): bool
    {
        return $year >= $this->startYear
            && ($year - $this->startYear) % $this->interval === 0;
    }
}
