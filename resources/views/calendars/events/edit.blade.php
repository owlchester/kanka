@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars.event.edit.title', ['name' => $entity->name]),
    'breadcrumbs' => isset($next) && $next == 'entity.events' ? [
        __('entities.' . $entity->pluralType()),
        ['url' => $entity->url(), 'label' => $entity->name],
        __('crud.tabs.reminders'),
        __('crud.update'),
    ] : [
        ['url' => route('calendars.index', $campaign), 'label' => __('entities.calendars')],
        ['url' => $entityEvent->calendar->getLink(), 'label' => $entityEvent->calendar->name],
        __('crud.tabs.reminders'),
        __('crud.update'),
    ],
    'canonical' => true,
])
@section('content')
    {!! Form::model($entityEvent, ['method' => 'PATCH', 'route' => ['entities.entity_events.update', $campaign, $entity->id, $entityEvent->id], 'data-shortcut' => '1', 'class' => 'ajax-validation', 'data-maintenance' => 1]) !!}

    <div class="modal-body">
        @include('partials.errors')

        @if (!empty($from))
            <x-alert type="warning">
                {!! __('calendars.event.helpers.other_calendar', ['calendar' => $from->tooltipedLink()]) !!}
            </x-alert>
        @endif

        @include('calendars.events._form', ['colourAppendTo' => '#entity-modal'])

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn2 btn-primary">
            <i class="fa-solid fa-spinner fa-spin" style="display:none;"></i>
            <span>{{ __('crud.save') }}</span>
        </button>
        <div class="pull-left">
            @include('partials.footer_cancel')

            <x-button.delete-confirm target="#delete-reminder-{{ $entityEvent->id}}" />
        </div>
    </div>

    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif
    {!! Form::close() !!}

    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['entities.entity_events.destroy', $campaign, $entity->id, $entityEvent->id],
        'id' => 'delete-reminder-' . $entityEvent->id]) !!}
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif
    {!! Form::close() !!}
@endsection
