<?php /** @var \App\Models\CalendarWeather $weather */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('calendars/weather.edit.title'),
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => __('calendars.index.title')],
        ['url' => route('calendars.show', $weather->calendar->id), 'label' => $weather->calendar->name],
        __('calendars.show.tabs.weather'),
        __('crud.update'),
    ],
    'canonical' => true,
])
@section('content')
    {!! Form::model($weather, ['method' => 'PATCH', 'route' => ['calendars.calendar_weather.update', $weather->calendar->id, $weather->id], 'data-shortcut' => '1']) !!}

    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            @include('calendars.weather._form')

        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <button class="btn btn-success">{{ __('crud.save') }}</button>
            </div>

            <a role="button" tabindex="0" class="btn btn-dynamic-delete btn-danger" data-toggle="popover"
               title="{{ __('crud.delete_modal.title') }}"
               data-content="<p>{{ __('crud.delete_modal.description_final', ['tag' => __('calendars/weather.actions.delete-confirm')]) }}</p>
                   <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-weather-{{ $weather->id}}'>{{ __('crud.remove') }}</a>">
                <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
            </a>
        </div>
    </div>


    {!! Form::hidden('year', $weather->year) !!}
    {!! Form::hidden('month', $weather->month) !!}
    {!! Form::hidden('day', $weather->day) !!}
    {!! Form::close() !!}


    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['calendars.calendar_weather.destroy', $weather->calendar->id, $weather->id],
        'id' => 'delete-weather-' . $weather->id]) !!}
    {!! Form::close() !!}
@endsection
