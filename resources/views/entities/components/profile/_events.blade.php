<?php
/**
 * @var \App\Models\EntityEvent $event
 * @var \App\Models\EntityEvent $birth
 * @var \App\Models\EntityEvent $death
 * @var \App\Models\EntityEvent[] $elapsed
 * @var \App\Models\Entity $entity
 */
$elapsed = $entity->elapsedEvents;

// Prepare birth and death events
$distinctCalendars = [];
$birth = null;
$death = null;
foreach ($elapsed as $event) {
    if (empty($event->calendar) || $event->isCalendarDate()) {
        continue;
    }
    if ($event->isBirth() || $event->isFounded()) {
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
    @php $birth = $calendarEvents['birth'] ?? null; $death = $calendarEvents['death'] ?? null; @endphp
    @if (!empty($birth) && !empty($death))
        <div class="element profile-life">
            <div class="title text-uppercase text-xs">{{ __('characters.fields.life') }}</div>
            <a href="{{ $birth->calendar->getLink() }}?year={{ $birth->year }}&month={{ $birth->month }}" data-title="{{ $birth->calendar->name }}" data-toggle="tooltip">
                {{ $birth->readableDate() }}
            </a> &#10013; <a href="{{ $death->calendar->getLink() }}?year={{ $death->year }}&month={{ $death->month }}" data-title="{{ $death->calendar->name }}" data-toggle="tooltip">
                {{ $death->readableDate() }}
            </a> ({{ $birth->calcElapsed($death) }})
        </div>

    @elseif (!empty($birth))
        @php $yearsAgo = $birth->calcElapsed() @endphp
        <div class="element profile-life profile-birth">
            @if ($birth->isBirth())
                <div class="title text-uppercase text-xs">{{ __('entities/events.types.birth') }}</div>
            @else
                <div class="title text-uppercase text-xs">{{ __('entities/events.types.founded') }}</div>
            @endif
            <a href="{{ $birth->calendar->getLink() }}?year={{ $birth->year }}&month={{ $birth->month }}" data-title="{{ $birth->calendar->name }}" data-toggle="tooltip">
            {{ $birth->readableDate() }}
            </a> ({{ $event->isBirth() ? $yearsAgo : trans_choice('entities/events.years-ago', $yearsAgo, ['count' => $yearsAgo]) }})
        </div>

    @elseif (!empty($death))
        <div class="element profile-life">
            <div class="title text-uppercase text-xs">{{ __('entities/events.types.death') }}</div>
            <a href="{{ $death->calendar->getLink() }}?year={{ $death->year }}&month={{ $death->month }}" data-title="{{ $death->calendar->name }}" data-toggle="tooltip">
            {{ $death->readableDate() }}
            </a> (&#10013;{{ $death->calcElapsed() }})
        </div>
    @endif
@endforeach
