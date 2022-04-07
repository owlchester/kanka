<?php
/** @var \App\Models\Entity $entity */
/** @var \App\Models\EntityEvent $relation */
?>

@if ($reminders->count() === 0)
    <p class="help-block">
        {!! __('entities/events.helpers.no_events') !!}
    </p>
    <a href="{{ route('entities.entity_events.create', [$entity, 'next' => 'entity.events']) }}"
       class="btn btn-sm btn-warning" data-toggle="ajax-modal" data-target="#entity-modal"
       data-url="{{ route('entities.entity_events.create', [$entity, 'next' => 'entity.events']) }}">
        <i class="fa fa-plus"></i> {{ __('entities/events.show.actions.add') }}
    </a>
@else

<table id="entity-event-list" class="table table-hover">
    <thead>
    <tr>
        <th class="avatar"></th>
        @if (auth()->check())
            <th><a href="{{ route('entities.entity_events.index', [$entity, 'order' => 'events/calendar.name', '#calendars']) }}">{{ __('calendars.fields.name') }}@if (request()->get('order') == 'events/calendar.name') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
            <th><a href="{{ route('entities.entity_events.index', [$entity, 'order' => 'events/date', '#calendars']) }}">{{ __('events.fields.date') }}@if (request()->get('order') == 'events/date') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
            <th><a href="{{ route('entities.entity_events.index', [$entity, 'order' => 'events/length', '#calendars']) }}">{{ __('calendars.fields.length') }}@if (request()->get('order') == 'events/length') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
            <th><a href="{{ route('entities.entity_events.index', [$entity, 'order' => 'events/comment', '#calendars']) }}">{{ __('calendars.fields.comment') }}@if (request()->get('order') == 'events/comment') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
            <th><br /></th>
        @else
            <th>{{ __('calendars.fields.name') }}</th>
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
        @viewentity($relation->calendar->entity)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $relation->calendar->getImageUrl(40) }}');" title="{{ $relation->calendar->name }}" href="{{ route('calendars.show', $relation->calendar->id) }}"></a>
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
                    <i class="fa fa-redo" title="{{ __('calendars.fields.is_recurring') }}"></i>
                @endif
                @if ($relation->type_id == 2)
                    <i class="fa fa-birthday-cake" title="{{ __('entities/events.types.birth') }}"></i>
                @elseif ($relation->type_id == 3)
                    <i class="fa fa-skull" title="{{ __('entities/events.types.death') }}"></i>
                @endif
            </td>
            <td class="text-right">
                @can('events', $relation->calendar)
                    <a href="{{ route('entities.entity_events.edit', [$relation->entity, $relation->id, 'next' => 'entity.events']) }}"
                    data-toggle="ajax-modal" data-url="{{ route('entities.entity_events.edit', [$relation->entity, $relation->id, 'next' => 'entity.events']) }}" data-target="#entity-modal">
                        <i class="fa fa-edit"></i>
                    </a>
                @endcan
            </td>
        </tr>
        @else
            <tr class="entity-hidden">
                <td colspan="7">{{ __('crud.hidden') }}</td>
            </tr>
            @endviewentity
            @endforeach
    </tbody>
</table>

{{ $reminders->fragment('tab_calendars')->links() }}
@endif
