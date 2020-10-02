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
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            @if (!empty($from))
                <div class="alert alert-warning">
                    {!! __('calendars.event.helpers.other_calendar', ['calendar' => $from->tooltipedLink()]) !!}

                </div>
            @endif

            {!! Form::model($entityEvent, ['method' => 'PATCH', 'route' => ['entities.entity_events.update', $entity->id, $entityEvent->id], 'data-shortcut' => '1']) !!}
            @include('calendars.events._form')

            <div class="row">
                <div class="col-xs-6 pull-right">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">{{ trans('crud.save') }}</button>
                        @if (!$ajax)
                            {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                        @endif
                    </div>

                    @if (!empty($next))
                        <input type="hidden" name="next" value="{{ $next }}" />
                    @endif
                    {!! Form::close() !!}
                </div>
                <div class="col-xs-6">
                    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_events.destroy', $entity->id, $entityEvent->id], 'style'=>'display:inline']) !!}
                    <button class="btn btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>
@endsection
