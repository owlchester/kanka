<?php
/** @var \App\Models\MiscModel $model */
/** @var \App\Models\EntityEvent $relation */

$r = $model
    ->entity
    ->events()
    ->has('calendar')
    ->with(['calendar', 'calendar.entity', 'entity'])
    ->order(request()->get('order'), 'events/date')
    ->paginate(); ?>
<p class="export-hidden">
    @can('events', $model)
    <a href="{{ route('entities.entity_events.create', [$model->entity, 'next' => 'entity.events']) }}" id="entity-calendar-modal-add"
       class="btn btn-sm btn-primary pull-right" data-toggle="ajax-modal" data-target="#entity-modal"
       data-url="{{ route('entities.entity_events.create', [$model->entity, 'next' => 'entity.events']) }}">
        <i class="fa fa-plus"></i> {{ trans('crud.add') }}
    </a>
    @endcan
    {{ trans('crud.events.hint') }}
</p>
<p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('crud.tabs.events') }}</p>
<table id="entity-event-list" class="table table-hover {{ ($r->count() == 0 ? 'export-hidden' : '') }}">
    <tbody><tr>
        <th class="avatar"></th>
        @if (auth()->check())
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'events/calendar.name', '#calendars']) }}">{{ trans('calendars.fields.name') }}@if (request()->get('order') == 'events/calendar.name') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'events/date', '#calendars']) }}">{{ trans('events.fields.date') }}@if (request()->get('order') == 'events/date') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'events/length', '#calendars']) }}">{{ trans('calendars.fields.length') }}@if (request()->get('order') == 'events/length') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        <th><a href="{{ route($name . '.show', [$model, 'order' => 'events/comment', '#calendars']) }}">{{ trans('calendars.fields.comment') }}@if (request()->get('order') == 'events/comment') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
        <th><br /></th>
        @else
        <th>{{ trans('calendars.fields.name') }}</th>
        <th>{{ trans('calendars.fields.date') }}</th>
        <th>{{ trans('calendars.fields.length') }}</th>
        <th>{{ trans('calendars.fields.comment') }}</th>
        <th></th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($r as $relation)
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
                    <i class="fa fa-redo" title="{{ trans('calendars.fields.is_recurring') }}"></i>
                @endif
                @if ($relation->type_id == 2)
                    <i class="fa fa-birthday-cake" title="{{ __('entities/events.types.birth') }}"></i>
                @elseif ($relation->type_id == 3)
                    <i class="fa fa-skull" title="{{ __('entities/events.types.death') }}"></i>
                @endif
            </td>
            <td class="text-right">
                @can('events', $relation->calendar)
                <a href="{{ route('entities.entity_events.edit', [$relation->entity, $relation->id, 'next' => 'entity.events']) }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-edit"></i>
                </a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_events.destroy', $relation->entity, $relation->id, 'next' => 'entity.events'], 'style' => 'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        @else
            <tr class="entity-hidden">
                <td colspan="7">{{ trans('crud.hidden') }}</td>
            </tr>
        @endviewentity
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_calendars')->links() }}
