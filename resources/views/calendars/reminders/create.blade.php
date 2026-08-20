@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('calendars.event.create.title', ['name' => $calendar->entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('calendars.index', $campaign), 'label' => __('entities.calendars')],
        ['url' => route('calendars.show', [$campaign, $calendar->id]), 'label' => $calendar->entity->name],
        trans('crud.tabs.reminders'),
    ],
    'canonical' => true,
    'centered' => true,
])

@section('content')
    <x-form :action="['calendars.event.store', $campaign, $calendar->id]" class="entity-calendar-subform">

    @include('partials.forms._dialog', [
        'title' => __('calendars.event.create.title', ['name' => $calendar->entity->name]),
        'content' => 'calendars.reminders._form',
        'dropdownParent' => '#primary-dialog',
    ])

    @if (request()->has('layout'))
        <input type="hidden" name="layout" value="{{ request()->get('layout') }}" />
    @endif
    </x-form>
@endsection
