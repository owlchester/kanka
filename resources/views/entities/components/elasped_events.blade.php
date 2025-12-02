<?php
/**
* @var \App\Models\EntityEvent $event
* @var \App\Models\EntityEvent|null $birth
* @var \App\Models\EntityEvent|null $death
* @var \App\Models\EntityEvent[] $elapsed
* @var \App\Models\Entity $entity
*/
$elapsed = $entity->elapsedEvents;

// Prepare the birth and death events
$distinctCalendars = [];
$birth = null;
$death = null;
foreach ($elapsed as $event) {
    if (empty($event->calendar) || $event->isCalendarDate()) {
        continue;
    }
    if ($event->isBirth()) {
        $distinctCalendars[$event->calendar_id]['birth'] = $event;
    } elseif ($event->isDeath()) {
        if (!isset($distinctCalendars[$event->calendar_id]['death'])) {
            $distinctCalendars[$event->calendar_id]['death'] = $event;
            continue;
        }

        // Already have a death? Take the new one if it's older
        $older = false;
        /** @var \App\Models\EntityEvent $previous */
        $previous = $distinctCalendars[$event->calendar_id]['death'];
        if ($previous->year < $event->year) {
            $older = true;
        } elseif ($previous->year == $event->year) {
            if ($previous->month < $event->month) {
                $older = true;
            } elseif ($previous->month == $event->month) {
                if ($previous->day < $event->day) {
                    $older = true;
                }
            }
        }

        if ($older) {
            $distinctCalendars[$event->calendar_id]['death'] = $event;
        }
    }
}
?>
@foreach ($distinctCalendars as $calendarId => $calendarEvents)
    @php
    /**
     * @var \App\Models\EntityEvent|null $birth
     * @var \App\Models\EntityEvent|null $death
     */
    $birth = $calendarEvents['birth'] ?? null;
    $death = $calendarEvents['death'] ?? null;
    @endphp
    @if (!empty($birth) && !empty($death))
        <li class="flex">
            <div class="grow font-bold">{{ __('characters.fields.life') }}</div>
            <div class="grow text-right">
                <a href="{{ $birth->calendar->getLink() }}?year={{ $birth->year }}&month={{ $birth->month }}" data-title="{{ $birth->calendar->name }}" data-toggle="tooltip">
                    {{ $birth->readableDate() }}
                </a> &#10013; <a href="{{ $death->calendar->getLink() }}?year={{ $death->year }}&month={{ $death->month }}" data-title="{{ $death->calendar->name }}" data-toggle="tooltip">
                    {{ $death->readableDate() }}
                </a> ({{ $birth->calcElapsed($death) }})
            </div>
        </li>
    @elseif (!empty($birth))
        <li class="flex">
            <div class="grow font-bold">{{ __('entities/events.types.birth') }}</div>
            <div class="grow text-right">
                <a href="{{ $birth->calendar->getLink() }}?year={{ $birth->year }}&month={{ $birth->month }}" data-title="{{ $birth->calendar->name }}" data-toggle="tooltip">
                {{ $birth->readableDate() }}
                </a> ({{ $birth->calcElapsed() }})
            </div>
        </li>
    @elseif (!empty($death))
        <li class="flex">
            <div class="grow font-bold">{{ __('entities/events.types.death') }}</div>
            <div class="grow text-right">
                <a href="{{ $death->calendar->getLink() }}?year={{ $death->year }}&month={{ $death->month }}" data-title="{{ $death->calendar->name }}" data-toggle="tooltip">
                {{ $death->readableDate() }}
                </a> ({{ $death->calcElapsed() }})
            </div>
        </li>
    @endif
@endforeach
