<?php

namespace App\ValueObjects\Calendars;

use App\Models\Reminder;

final readonly class ReminderOccurrence
{
    public function __construct(
        public Reminder $reminder,
        public Occurrence $occurrence,
        public int $distance,
        public string $state,
    ) {}

    public function isActive(): bool
    {
        return $this->state === 'active';
    }
}
