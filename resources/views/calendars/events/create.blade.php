@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('calendars.event.create.title', ['name' => $calendar->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => trans('calendars.index.title')],
        ['url' => route('calendars.show', $calendar->id), 'label' => $calendar->name],
        trans('crud.tabs.reminders'),
    ],
    'canonical' => true,
])

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::open(['route' => ['calendars.event.store', $calendar->id], 'method'=>'POST', 'data-shortcut' => 1, 'class' => 'ajax-validation']) !!}
            @include('calendars.events._form')

            <div class="form-group">
                <button class="btn btn-success" id="calendar-event-submit" style="display: none">
                    <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                    <span>{{ __('crud.save') }}</span>
                </button>
                @includeWhen(!$ajax, 'partials.or_cancel')
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
