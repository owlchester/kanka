<?php

namespace App\ValueObjects\Calendars;

use Illuminate\Support\Collection;

final readonly class ReminderWindow
{
    /** @param Collection<int, ReminderOccurrence> $past */
    /** @param Collection<int, ReminderOccurrence> $upcoming */
    public function __construct(
        public Collection $past,
        public Collection $upcoming,
    ) {}
}
