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
| {{ __('characters.fields.life') }} | {{ $birth->readableDate() }} &#10013; {{ $death->readableDate() }} ({{ $birth->calcElapsed($death) }}) |
@elseif (!empty($birth))
@php $yearsAgo = $birth->calcElapsed() @endphp
@if ($birth->isBirth())
| {{ __('entities/events.types.birth') }} | {{ $birth->readableDate() }} ({{ $event->isBirth() ? $yearsAgo : trans_choice('entities/events.years-ago', $yearsAgo, ['count' => $yearsAgo]) }}) |
@else
| {{ __('entities/events.types.founded') }} | {{ $birth->readableDate() }} ({{ $event->isBirth() ? $yearsAgo : trans_choice('entities/events.years-ago', $yearsAgo, ['count' => $yearsAgo]) }}) |
@endif
@elseif (!empty($death))
| {{ __('entities/events.types.death') }} | {{ $death->readableDate() }} (&#10013;{{ $death->calcElapsed() }}) |
@endif
@endforeach
