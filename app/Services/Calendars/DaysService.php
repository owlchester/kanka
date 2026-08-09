<?php

namespace App\Services\Calendars;

use App\Traits\CalendarAware;
use App\ValueObjects\Calendars\CalendarDate;

class DaysService
{
    use CalendarAware;

    protected bool $intercalary = true;

    protected int $month;

    protected int $year;

    protected int $day;

    public function intercalary(bool $intercalary): self
    {
        $this->intercalary = $intercalary;

        return $this;
    }

    public function month(int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function day(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function year(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function daysToDate(): int
    {
        return $this->calendar->chronology()->toOrdinal(
            new CalendarDate($this->year, $this->month, 1),
            $this->intercalary,
        );
    }
}
