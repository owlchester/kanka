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
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($weather, ['method' => 'PATCH', 'route' => ['calendars.calendar_weather.update', $weather->calendar->id, $weather->id], 'data-shortcut' => '1']) !!}
            @include('calendars.weather._form')

            <div class="row">
                <div class="col-md-6 pull-right text-right ">
                    <div class="form-group text-right">
                        <button class="btn btn-success">{{ __('crud.save') }}</button>
                        @if (!$ajax)
                            {!! __('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                        @endif
                    </div>
                    {!! Form::hidden('year', $weather->year) !!}
                    {!! Form::hidden('month', $weather->month) !!}
                    {!! Form::hidden('day', $weather->day) !!}
                    {!! Form::close() !!}
                </div>
                <div class="col-md-6">
                    {!! Form::open(['method' => 'DELETE', 'route' => ['calendars.calendar_weather.destroy', $weather->calendar->id, $weather->id], 'style' => 'display:inline']) !!}
                    <button class="btn btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>
@endsection
