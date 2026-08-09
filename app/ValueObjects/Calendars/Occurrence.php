<?php

namespace App\ValueObjects\Calendars;

use JsonSerializable;

final readonly class Occurrence implements JsonSerializable
{
    public function __construct(
        public CalendarDate $start,
        public CalendarDate $end,
        public int $sequence,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'start' => $this->start,
            'end' => $this->end,
            'sequence' => $this->sequence,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
