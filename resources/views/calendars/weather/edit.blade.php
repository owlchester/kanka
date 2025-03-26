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
    <x-form method="PATCH" :action="['calendars.calendar_weather.update', $campaign, $weather->calendar->id, $weather->id]">

    @include('partials.forms._dialog', [
        'title' => __('calendars/weather.edit.title'),
        'content' => 'calendars.weather._form',
        'deleteID' => '#delete-weather-' . $weather->id,
    ])

    <input type="hidden" name="year" value="{{ $weather->year }}" />
    <input type="hidden" name="month" value="{{ $weather->month }}" />
    <input type="hidden" name="day" value="{{ $weather->day }}" />
    @if (request()->has('layout'))
        <input type="hidden" name="layout" value="{{ request()->get('layout') }}" />
    @endif
    </x-form>


    <x-form method="DELETE" :action="['calendars.calendar_weather.destroy', $campaign, $weather->calendar->id, $weather->id]" id="delete-weather-{{ $weather->id }}">
    @if (request()->has('layout'))
        <input type="hidden" name="layout" value="{{ request()->get('layout') }}" />
        <input type="hidden" name="year" value="{{ $year }}" />
        <input type="hidden" name="month" value="{{ $month }}" />
        <input type="hidden" name="day" value="{{ $day }}" />
    @endif
    </x-form>
@endsection
