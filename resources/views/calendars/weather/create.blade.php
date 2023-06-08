@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('calendars/weather.create.title', ['name' => $calendar->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('calendars'), 'label' => \App\Facades\Module::plural(config('entities.ids.calendar'), __('entities.calendars'))],
        ['url' => $calendar->getLink(), 'label' => $calendar->name],
        __('calendars.show.tabs.weather'),
    ],
    'canonical' => true,
])

@section('content')
    {!! Form::open(['route' => ['calendars.calendar_weather.store', $calendar->id], 'method' => 'POST', 'data-shortcut' => '1']) !!}

    @include('partials.forms.form', [
        'title' => __('calendars/weather.create.title', ['name' => $calendar->name]),
        'content' => 'calendars.weather._form',
    ])

    {!! Form::hidden('year', $year) !!}
    {!! Form::hidden('month', $month) !!}
    {!! Form::hidden('day', $day) !!}
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif

    {!! Form::close() !!}
@endsection
