<?php
/**
* @var \App\Models\EntityEvent $event
* @var \App\Models\EntityEvent $birth
* @var \App\Models\EntityEvent $death
* @var \App\Models\EntityEvent[] $elapsed
* @var \App\Models\MiscModel $model
*/
$elapsed = $model->entity->elapsedEvents;

// Prepare birth and death events
$distinctCalendars = [];
$birth = null;
$death = null;
foreach ($elapsed as $event) {
    if (empty($event->calendar)) {
        continue;
    }
    if ($event->type_id == 2) {
        $distinctCalendars[$event->calendar_id]['birth'] = $event;
    } elseif ($event->type_id == 3) {
        $distinctCalendars[$event->calendar_id]['death'] = $event;
    }
}
?>
@foreach ($distinctCalendars as $calendarId => $calendarEvents)
    @php $birth = $calendarEvents['birth'] ?? null; $death = $calendarEvents['death'] ?? null; @endphp
    @if (!empty($birth) && !empty($death))

        <li class="list-group-item">
            <b>{{ __('characters.fields.life') }}</b><br />
            <span class="pull-right">
                <a href="{{ $birth->calendar->getLink() }}?year={{ $birth->year }}&month={{ $birth->month }}" title="{{ $birth->calendar->name }}" data-toggle="tooltip">
                    {{ $birth->readableDate() }}
                </a> &#10013; <a href="{{ $death->calendar->getLink() }}?year={{ $death->year }}&month={{ $death->month }}" title="{{ $death->calendar->name }}" data-toggle="tooltip">
                    {{ $death->readableDate() }}
                </a> ({{ $birth->calcElasped($death) }})
            </span>
            <br class="clear" />
        </li>

    @elseif (!empty($birth))
        <li class="list-group-item">
            <b>{{ __('entities/events.types.birth') }}</b>
            <span class="pull-right">
                <a href="{{ $birth->calendar->getLink() }}?year={{ $birth->year }}&month={{ $birth->month }}" title="{{ $birth->calendar->name }}" data-toggle="tooltip">
                {{ $birth->readableDate() }}
                </a> ({{ $birth->calcElasped() }})
            </span>
            <br class="clear" />
        </li>

    @elseif (!empty($death))
        <li class="list-group-item">
            <b>{{ __('entities/events.types.death') }}</b>
            <span class="pull-right">
                <a href="{{ $death->calendar->getLink() }}?year={{ $death->year }}&month={{ $death->month }}" title="{{ $death->calendar->name }}" data-toggle="tooltip">
                {{ $death->readableDate() }}
                </a> ({{ $death->calcElasped() }})
            </span>
            <br class="clear" />
        </li>

    @endif
@endforeach
