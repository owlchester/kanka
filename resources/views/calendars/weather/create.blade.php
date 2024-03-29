@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars/weather.create.title', ['name' => $calendar->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($calendar->entity)->list(),
        Breadcrumb::show($calendar),
        __('calendars.show.tabs.weather'),
    ],
    'canonical' => true,
    'centered' => true,
])

@section('content')
    {!! Form::open(['route' => ['calendars.calendar_weather.store', $campaign, $calendar->id], 'method' => 'POST', 'data-shortcut' => '1']) !!}

    @include('partials.forms.form', [
        'title' => __('calendars/weather.create.title', ['name' => $calendar->name]),
        'content' => 'calendars.weather._form',
        'dialog' => true,
    ])

    {!! Form::hidden('year', $year) !!}
    {!! Form::hidden('month', $month) !!}
    {!! Form::hidden('day', $day) !!}
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif

    {!! Form::close() !!}
@endsection
