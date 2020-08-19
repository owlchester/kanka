@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('calendars.event.create.title', ['name' => $calendar->name]),
    'description' => trans('calendars.event.create.description'),
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

            {!! Form::open(['route' => ['calendars.event.store', $calendar->id], 'method'=>'POST', 'data-shortcut' => 1]) !!}
            @include('calendars.events._form')

            <div class="form-group">
                <button class="btn btn-success" id="calendar-event-submit" style="display: none">{{ trans('crud.save') }}</button>
                @if (!$ajax)
                    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '#relation') === false ? '#relation' : null))]) !!}
                @endif
            </div>

            {!! Form::close() !!}
        </div>    </div>
@endsection
