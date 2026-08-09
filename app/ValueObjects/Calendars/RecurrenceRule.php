<?php

namespace App\ValueObjects\Calendars;

use InvalidArgumentException;
use JsonSerializable;

final readonly class RecurrenceRule implements JsonSerializable
{
    public const DAILY = 'day';

    public const WEEKLY = 'week';

    public const MONTHLY = 'month';

    public const YEARLY = 'year';

    public const MOON_PHASE = 'moon_phase';

    public function __construct(
        public string $frequency,
        public int $interval = 1,
        public ?int $untilYear = null,
        public ?int $moonId = null,
        public ?string $phase = null,
        public string $invalidDate = 'skip',
    ) {
        if ($this->interval < 1 || ! in_array($this->frequency, [
            self::DAILY,
            self::WEEKLY,
            self::MONTHLY,
            self::YEARLY,
            self::MOON_PHASE,
        ], true)) {
            throw new InvalidArgumentException('Invalid recurrence rule.');
        }

        if (! in_array($this->invalidDate, ['skip', 'clamp'], true)) {
            throw new InvalidArgumentException('Invalid recurrence date policy.');
        }

        if ($this->frequency === self::MOON_PHASE && ($this->moonId === null || $this->phase === null)) {
            throw new InvalidArgumentException('Moon recurrence requires a moon and phase.');
        }
    }

    public function toArray(): array
    {
        return array_filter([
            'version' => 1,
            'frequency' => $this->frequency,
            'interval' => $this->interval,
            'until_year' => $this->untilYear,
            'moon_id' => $this->moonId,
            'phase' => $this->phase,
            'invalid_date' => $this->invalidDate,
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
