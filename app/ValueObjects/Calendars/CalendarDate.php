<?php

namespace App\ValueObjects\Calendars;

use InvalidArgumentException;
use JsonSerializable;
use Stringable;

final readonly class CalendarDate implements JsonSerializable, Stringable
{
    public function __construct(
        public int $year,
        public int $month,
        public int $day,
    ) {
        if ($this->month < 1 || $this->day < 1) {
            throw new InvalidArgumentException('Calendar dates must use positive months and days.');
        }
    }

    public static function fromString(string $date): self
    {
        if (! preg_match('/^(-?\d+)-(\d+)-(\d+)$/', $date, $parts)) {
            throw new InvalidArgumentException("Invalid calendar date: {$date}");
        }

        return new self((int) $parts[1], (int) $parts[2], (int) $parts[3]);
    }

    /** @param array{0: int|string, 1: int|string, 2: int|string} $date */
    public static function fromArray(array $date): self
    {
        return new self((int) $date[0], (int) $date[1], (int) $date[2]);
    }

    public function key(): string
    {
        return (string) $this;
    }

    /** @return array{year: int, month: int, day: int, key: string} */
    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'key' => $this->key(),
        ];
    }

    public function compare(self $other): int
    {
        return $this->year <=> $other->year
            ?: $this->month <=> $other->month
            ?: $this->day <=> $other->day;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function __toString(): string
    {
        return "{$this->year}-{$this->month}-{$this->day}";
    }
}
