<?php
/**
* @var \App\Models\Reminder $event
* @var ?\App\Models\Reminder $birth
* @var ?\App\Models\Reminder $death
* @var \App\Models\Reminder[] $elapsed
* @var \App\Models\Entity $entity
*/
$elapsed = $entity->elapsedEvents;

// Prepare the birth and death events
$distinctCalendars = [];
$birth = null;
$death = null;
foreach ($elapsed as $event) {
    if (empty($event->calendar) || empty($event->calendar->entity) || $event->isCalendarDate()) {
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
                <a href="{{ route('entities.show', [$campaign, $birth->calendar->entity]) }}?year={{ $birth->year }}&month={{ $birth->month }}" data-title="{{ $birth->calendar->name }}" data-toggle="tooltip" class="text-link">
                    {{ $birth->readableDate() }}
                </a> &#10013; <a href="{{ route('entities.show', [$campaign, $death->calendar->entity]) }}?year={{ $death->year }}&month={{ $death->month }}" data-title="{{ $death->calendar->name }}" data-toggle="tooltip" class="text-link">
                    {{ $death->readableDate() }}
                </a> ({{ $birth->calcElapsed($death) }})
            </div>
        </li>
    @elseif (!empty($birth))
        <li class="flex">
            <div class="grow font-bold">{{ __('entities/events.types.birth') }}</div>
            <div class="grow text-right">
                <a href="{{ route('entities.show', [$campaign, $birth->calendar->entity]) }}?year={{ $birth->year }}&month={{ $birth->month }}" data-title="{{ $birth->calendar->name }}" data-toggle="tooltip" class="text-link">
                {{ $birth->readableDate() }}
                </a> ({{ $birth->calcElapsed() }})
            </div>
        </li>
    @elseif (!empty($death))
        <li class="flex">
            <div class="grow font-bold">{{ __('entities/events.types.death') }}</div>
            <div class="grow text-right">
                <a href="{{ route('entities.show', [$campaign, $death->calendar->entity]) }}?year={{ $death->year }}&month={{ $death->month }}" data-title="{{ $death->calendar->name }}" data-toggle="tooltip" class="text-link">
                {{ $death->readableDate() }}
                </a> ({{ $death->calcElapsed() }})
            </div>
        </li>
    @endif
@endforeach
