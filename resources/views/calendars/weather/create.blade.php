@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('calendars/weather.create.title', ['name' => $calendar->name]),
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => trans('calendars.index.title')],
        ['url' => route('calendars.show', $calendar->id), 'label' => $calendar->name],
        trans('calendars.show.tabs.weather'),
    ],
    'canonical' => true,
])

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::open(['route' => ['calendars.calendar_weather.store', $calendar->id], 'method' => 'POST', 'data-shortcut' => '1']) !!}
            @include('calendars.weather._form')

            <div class="form-group">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                @if (!$ajax)
                    {!! __('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                @endif
            </div>

            {!! Form::hidden('year', $year) !!}
            {!! Form::hidden('month', $month) !!}
            {!! Form::hidden('day', $day) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
