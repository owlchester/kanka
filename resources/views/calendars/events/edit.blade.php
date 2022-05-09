@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('calendars.event.edit.title', ['name' => $entity->name]),
    'breadcrumbs' => isset($next) && $next == 'entity.events' ? [
        trans($entity->pluralType() . '.index.title'),
        ['url' => $entity->url(), 'label' => $entity->name],
        trans('crud.tabs.reminders'),
        trans('crud.update'),
    ] : [
        ['url' => route('calendars.index'), 'label' => trans('calendars.index.title')],
        ['url' => $entityEvent->calendar->getLink(), 'label' => $entityEvent->calendar->name],
        trans('crud.tabs.reminders'),
        trans('crud.update'),
    ],
    'canonical' => true,
])
@section('content')
    {!! Form::model($entityEvent, ['method' => 'PATCH', 'route' => ['entities.entity_events.update', $entity->id, $entityEvent->id], 'data-shortcut' => '1', 'class' => 'ajax-validation']) !!}

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
               data-content="<p>{{ __('crud.delete_modal.description_final', ['tag' => __('calendars.event.actions.delete-confirm')]) }}</p>
                   <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-reminder-{{ $entityEvent->id}}'>{{ __('crud.remove') }}</a>">
                <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
            </a>
        </div>

    </div>


    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    {!! Form::close() !!}

    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['entities.entity_events.destroy', $entity->id, $entityEvent->id],
        'id' => 'delete-reminder-' . $entityEvent->id]) !!}
    {!! Form::close() !!}
@endsection
