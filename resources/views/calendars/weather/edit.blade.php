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
    'centered' => true,
])
@section('content')
    {!! Form::model($weather, ['method' => 'PATCH', 'route' => ['calendars.calendar_weather.update', $campaign, $weather->calendar->id, $weather->id], 'data-shortcut' => '1']) !!}

    @include('partials.forms.form', [
        'title' => __('calendars/weather.edit.title'),
        'content' => 'calendars.weather._form',
        'deleteID' => '#delete-weather-' . $weather->id,
        'dialog' => true,
    ])

    <input type="hidden" name="year" value="{{ $weather->year }}" />
    <input type="hidden" name="month" value="{{ $weather->month }}" />
    <input type="hidden" name="day" value="{{ $weather->day }}" />
    @if (request()->has('layout'))
        <input type="hidden" name="layout" value="{{ request()->get('layout') }}" />
    @endif
    {!! Form::close() !!}


    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['calendars.calendar_weather.destroy', $campaign, $weather->calendar->id, $weather->id],
        'id' => 'delete-weather-' . $weather->id]) !!}
    @if (request()->has('layout'))
        <input type="hidden" name="layout" value="{{ request()->get('layout') }}" />
        <input type="hidden" name="year" value="{{ $year }}" />
        <input type="hidden" name="month" value="{{ $month }}" />
        <input type="hidden" name="day" value="{{ $day }}" />
    @endif
    {!! Form::close() !!}
@endsection
