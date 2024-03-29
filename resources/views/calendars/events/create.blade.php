@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('calendars.event.create.title', ['name' => $calendar->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('calendars.index', $campaign), 'label' => __('entities.calendars')],
        ['url' => route('calendars.show', [$campaign, $calendar->id]), 'label' => $calendar->name],
        trans('crud.tabs.reminders'),
    ],
    'canonical' => true,
    'centered' => true,
])

@section('content')
    {!! Form::open([
        'method' => 'POST',
        'route' => ['calendars.event.store', $campaign, $calendar->id],
        'data-shortcut' => 1,
        'class' => 'ajax-subform entity-calendar-subform',
        'data-maintenance' => 1
    ]) !!}

    @include('partials.forms.form', [
        'title' => __('calendars.event.create.title', ['name' => $calendar->name]),
        'content' => 'calendars.events._form',
        'dialog' => true,
        'dropdownParent' => '#primary-dialog',
    ])

    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif

    {!! Form::close() !!}
@endsection
