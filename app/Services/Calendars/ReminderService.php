<?php

namespace App\Services\Calendars;

use App\Models\Calendar;
use App\Models\Entity;
use App\Models\Post;
use App\Models\Reminder;
use App\ValueObjects\Calendars\CalendarDate;
use App\ValueObjects\Calendars\ReminderOccurrence;
use App\ValueObjects\Calendars\ReminderWindow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class ReminderService
{
    protected Calendar $calendar;

    public function __construct(
        private readonly LegacyRecurrenceAdapter $adapter,
    ) {}

    public function calendar(Calendar $calendar): self
    {
        $this->calendar = $calendar;

        return $this;
    }

    public function around(int $limit = 5): ReminderWindow
    {
        $today = new CalendarDate(
            $this->calendar->currentYear(),
            $this->calendar->currentMonth(),
            $this->calendar->currentDay(),
        );
        $chronology = $this->calendar->chronology();
        $engine = new OccurrenceEngine($chronology, new MoonPhaseCalculator($chronology));
        $past = collect();
        $upcoming = collect();

        foreach ($this->reminders() as $reminder) {
            $reminder->setRelation('calendar', $this->calendar);

            try {
                $anchor = new CalendarDate((int) $reminder->year, (int) $reminder->month, (int) $reminder->day);
                if (! $chronology->isValid($anchor)) {
                    continue;
                }
                $rule = $this->adapter->fromReminder($reminder);
                $next = $engine->nextOrActiveOccurrence($anchor, (int) $reminder->length, $rule, $today);
                $previous = $engine->previousOccurrence($anchor, (int) $reminder->length, $rule, $today);

                if ($previous !== null) {
                    $past->push(new ReminderOccurrence(
                        $reminder,
                        $previous,
                        $chronology->toOrdinal($today) - $chronology->toOrdinal($previous->end),
                        'past',
                    ));
                }
                if ($next !== null) {
                    $state = $next->start->compare($today) <= 0 && $next->end->compare($today) >= 0
                        ? 'active'
                        : 'upcoming';
                    $upcoming->push(new ReminderOccurrence(
                        $reminder,
                        $next,
                        $state === 'active' ? 0 : $chronology->toOrdinal($next->start) - $chronology->toOrdinal($today),
                        $state,
                    ));
                }
            } catch (InvalidArgumentException) {
                // Invalid historical reminder dates should not prevent the widget from rendering.
            }
        }

        $past = $past->sort(static function (ReminderOccurrence $a, ReminderOccurrence $b) use ($chronology): int {
            return $chronology->toOrdinal($b->occurrence->end) <=> $chronology->toOrdinal($a->occurrence->end)
                ?: $b->reminder->id <=> $a->reminder->id;
        })->take(max(0, $limit))->values();
        $upcoming = $upcoming->sort(static function (ReminderOccurrence $a, ReminderOccurrence $b) use ($chronology): int {
            return (int) $b->isActive() <=> (int) $a->isActive()
                ?: $chronology->toOrdinal($a->occurrence->start) <=> $chronology->toOrdinal($b->occurrence->start)
                ?: $a->reminder->id <=> $b->reminder->id;
        })->take(max(0, $limit))->values();

        return new ReminderWindow($past, $upcoming);
    }

    /** @return Collection<int, ReminderOccurrence> */
    public function upcoming(int $limit = 5): Collection
    {
        return $this->around($limit)->upcoming;
    }

    /** @return Collection<int, ReminderOccurrence> */
    public function past(int $limit = 5): Collection
    {
        return $this->around($limit)->past;
    }

    /** @return Collection<int, Reminder> */
    private function reminders(): Collection
    {
        // @phpstan-ignore-next-line
        return $this->calendar->calendarEvents()
            ->with([
                'remindable' => function ($morphTo): void {
                    $morphTo->morphWith([
                        Entity::class => [],
                        Post::class => ['entity'],
                    ]);
                },
            ])
            ->whereHasMorph(
                'remindable',
                [Entity::class, Post::class],
                function (Builder $query, string $type): void {
                    if ($type === Post::class) {
                        $query->whereHas('entity');
                    }
                },
            )
            ->orderBy('id')
            ->get();
    }
}
