@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('calendars.event.edit.title', ['name' => $entity->name]),
    'breadcrumbs' => isset($next) && $next == 'entity.events' ? [
        __('entities.' . $entity->pluralType()),
        ['url' => $entity->url(), 'label' => $entity->name],
        __('crud.tabs.reminders'),
        __('crud.update'),
    ] : [
        ['url' => route('calendars.index', [$campaign]), 'label' => __('entities.calendars')],
        ['url' => $entityEvent->calendar->getLink(), 'label' => $entityEvent->calendar->name],
        __('crud.tabs.reminders'),
        __('crud.update'),
    ],
    'canonical' => true,
])
@section('content')
    {!! Form::model($entityEvent, ['method' => 'PATCH', 'route' => ['entities.entity_events.update', [$campaign, $entity, $entityEvent]], 'data-shortcut' => '1', 'class' => 'ajax-validation', 'data-maintenance' => 1]) !!}

    @if (request()->ajax())
        <div class="modal-body">
            @include('partials.errors')

            @if (!empty($from))
                <div class="alert alert-warning">
                    {!! __('calendars.event.helpers.other_calendar', ['calendar' => $from->tooltipedLink()]) !!}

                </div>
            @endif

            @include('calendars.events._form')
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-spinner fa-spin" style="display:none;"></i>
                <span>{{ __('crud.save') }}</span>
            </button>
            <div class="pull-left">
                @include('partials.footer_cancel')
                <a role="button" tabindex="0" class="btn btn-dynamic-delete btn-danger" data-toggle="popover"
                   title="{{ __('crud.delete_modal.title') }}"
                   data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                   <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-reminder-{{ $entityEvent->id}}'>{{ __('crud.remove') }}</a>">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                </a>
            </div>
        </div>
    @else
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            @if (!empty($from))
                <div class="alert alert-warning">
                    {!! __('calendars.event.helpers.other_calendar', ['calendar' => $from->tooltipedLink()]) !!}

                </div>
            @endif

            @include('calendars.events._form')

        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-spinner fa-spin" style="display:none;"></i>
                    <span>{{ __('crud.save') }}</span>
                </button>
            </div>

            <a role="button" tabindex="0" class="btn btn-dynamic-delete btn-danger" data-toggle="popover"
               title="{{ __('crud.delete_modal.title') }}"
               data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                   <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-reminder-{{ $entityEvent->id}}'>{{ __('crud.remove') }}</a>">
                <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
            </a>
        </div>

    </div>
    @endif


    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif
    {!! Form::close() !!}

    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['entities.entity_events.destroy', [$campaign, $entity, $entityEvent]],
        'id' => 'delete-reminder-' . $entityEvent->id]) !!}
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif
    {!! Form::close() !!}
@endsection
