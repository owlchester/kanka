<?php
/** @var \App\Models\Entity $entity */
/** @var \App\Models\EntityEvent $relation */
?>

<table id="entity-event-list" class="table table-hover">
    <thead>
    <tr>
        <th class="w-14"></th>
        @if (auth()->check())
            <th>
                <a href="{{ route('entities.entity_events.index', [$entity, 'order' => 'events/calendar.name', '#calendars']) }}">{{ __('entities.calendar') }}@if (request()->get('order') == 'events/calendar.name') <i class="fa-solid fa-long-arrow-down" aria-hidden="true"></i>@endif</a>
            </th>
            <th>
                <a href="{{ route('entities.entity_events.index', [$entity, 'order' => 'events/date', '#calendars']) }}">{{ __('events.fields.date') }}@if (request()->get('order') == 'events/date') <i class="fa-solid fa-long-arrow-down" aria-hidden="true"></i>@endif</a>
            </th>
            <th>
                <a href="{{ route('entities.entity_events.index', [$entity, 'order' => 'events/length', '#calendars']) }}">{{ __('calendars.fields.length') }}@if (request()->get('order') == 'events/length') <i class="fa-solid fa-long-arrow-down" aria-hidden="true"></i>@endif</a>
            </th>
            <th>
                <a href="{{ route('entities.entity_events.index', [$entity, 'order' => 'events/comment', '#calendars']) }}">{{ __('calendars.fields.comment') }}@if (request()->get('order') == 'events/comment') <i class="fa-solid fa-long-arrow-down" aria-hidden="true"></i>@endif</a>
            </th>
            <th><br /></th>
        @else
            <th>{{ __('entitites.calendar') }}</th>
            <th>{{ __('calendars.fields.date') }}</th>
            <th>{{ __('calendars.fields.length') }}</th>
            <th>{{ __('calendars.fields.comment') }}</th>
            <th></th>
        @endif
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($reminders as $relation)
        <tr>
            <td>
                <x-entities.thumbnail :entity="$relation->calendar->entity" :title="$relation->calendar->name"></x-entities.thumbnail>
            </td>
            <td>
                {!! $relation->calendar->tooltipedLink() !!}
            </td>
            <td>
                <a href="{{ $relation->calendar->getLink() }}?year={{ $relation->year }}&month={{ $relation->month }}">
                    {{ $relation->readableDate() }}
                </a>
            </td>
            <td>{{ trans_choice('calendars.fields.length_days', $relation->length, ['count' => $relation->length]) }}</td>
            <td>{{ $relation->comment }}</td>
            <td>
                @if ($relation->is_recurring)
                    <i class="fa-solid fa-redo" title="{{ __('calendars.fields.is_recurring') }}" data-toggle="tooltip" aria-hidden="true"></i>
                @endif
                @if ($relation->isBirth())
                    <i class="fa-solid fa-birthday-cake" title="{{ __('entities/events.types.birth') }}" data-toggle="tooltip" aria-hidden="true"></i>
                @elseif ($relation->isDeath())
                    <i class="fa-solid fa-skull" title="{{ __('entities/events.types.death') }}" data-toggle="tooltip" aria-hidden="true"></i>
                @elseif ($relation->isFounded())
                    <i class="fa-solid fa-building-columns" title="{{ __('entities/events.types.founded') }}" data-toggle="tooltip" aria-hidden="true"></i>
                @endif
            </td>
            <td class="text-right">
                @can('events', $relation->calendar)
                    <a href="{{ route('entities.entity_events.edit', [$relation->entity, $relation->id, 'next' => 'entity.events']) }}"
                    data-toggle="ajax-modal" data-url="{{ route('entities.entity_events.edit', [$relation->entity, $relation->id, 'next' => 'entity.events']) }}" data-target="#entity-modal">
                        <i class="fa-solid fa-edit" aria-hidden="true"></i>
                    </a>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $reminders->fragment('tab_calendars')->links() }}
