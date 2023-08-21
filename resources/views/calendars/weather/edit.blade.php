<?php /** @var \App\Models\CalendarWeather $weather */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars/weather.edit.title'),
    'breadcrumbs' => [
        Breadcrumb::entity($weather->calendar->entity)->list(),
        Breadcrumb::show($weather->calendar),
        __('calendars.show.tabs.weather'),
        __('crud.update'),
    ],
    'canonical' => true,
])
@section('content')
    {!! Form::model($weather, ['method' => 'PATCH', 'route' => ['calendars.calendar_weather.update', $campaign, $weather->calendar->id, $weather->id], 'data-shortcut' => '1']) !!}

    @include('partials.forms.form', [
        'title' => __('calendars/weather.edit.title'),
        'content' => 'calendars.weather._form',
        'deleteID' => '#delete-weather-' . $weather->id,
        'dialog' => true,
    ])

    {!! Form::hidden('year', $weather->year) !!}
    {!! Form::hidden('month', $weather->month) !!}
    {!! Form::hidden('day', $weather->day) !!}
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif
    {!! Form::close() !!}


    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['calendars.calendar_weather.destroy', $campaign, $weather->calendar->id, $weather->id],
        'id' => 'delete-weather-' . $weather->id]) !!}
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
        {!! Form::hidden('year', $year) !!}
        {!! Form::hidden('month', $month) !!}
        {!! Form::hidden('day', $day) !!}
    @endif
    {!! Form::close() !!}
@endsection
