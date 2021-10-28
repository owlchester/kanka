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
    {!! Form::open(['route' => ['calendars.calendar_weather.store', $calendar->id], 'method' => 'POST', 'data-shortcut' => '1']) !!}

    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            @include('calendars.weather._form')
        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <button class="btn btn-success">{{ __('crud.save') }}</button>
            </div>
            @include('partials.footer_cancel')
        </div>
    </div>

    {!! Form::hidden('year', $year) !!}
    {!! Form::hidden('month', $month) !!}
    {!! Form::hidden('day', $day) !!}

    {!! Form::close() !!}
@endsection
