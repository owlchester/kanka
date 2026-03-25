<?php
/**
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\CalendarEra $model
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars/eras.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($calendar->entity)->list(),
        Breadcrumb::show(),
        __('calendars/eras.edit.title', ['name' => $model->name])
    ],
    'centered' => true,
])
@section('content')
    @include('partials.errors')

    <x-form
        :action="['calendars.calendar_eras.update', $campaign, 'calendar' => $calendar, 'calendar_era' => $model]"
        method="PATCH"
        id="calendar-era-form">
        <x-box>
            @include('calendars.eras._form')

            <x-dialog.footer>
                <button class="btn2 btn-primary">{{ __('crud.save') }}</button>
            </x-dialog.footer>
        </x-box>
    </x-form>
@endsection
