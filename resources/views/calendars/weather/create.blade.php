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

    @if (request()->ajax())
        <div class="modal-body">
            @include('partials.errors')
            @include('calendars.weather._form')
        </div>
        <div class="modal-footer">
            <button class="btn btn-success">{{ __('crud.save') }}</button>
            <div class="pull-left">
                @include('partials.footer_cancel')
            </div>
        </div>
    @else
        <x-box>
            @include('partials.errors')

            @include('calendars.weather._form')
            <x-box.footer>
                <div class="pull-right">
                    <button class="btn btn-success">{{ __('crud.save') }}</button>
                </div>
                @include('partials.footer_cancel')
            </x-box.footer>
        </x-box>
    @endif

    {!! Form::hidden('year', $year) !!}
    {!! Form::hidden('month', $month) !!}
    {!! Form::hidden('day', $day) !!}
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif

    {!! Form::close() !!}
@endsection
