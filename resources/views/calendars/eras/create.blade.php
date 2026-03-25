<?php
/**
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars/eras.create.title'),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($calendar->entity)->list(),
        Breadcrumb::show(),
        __('calendars/eras.create.title')
    ],
    'centered' => true,
])
@section('content')
    @include('partials.errors')

    <x-form :action="['calendars.calendar_eras.store', $campaign, $calendar]" id="calendar-era-form">
        <x-box>
            @include('calendars.eras._form', ['model' => null])

            <x-dialog.footer>
                <button class="btn2 btn-primary">{{ __('crud.save') }}</button>
            </x-dialog.footer>
        </x-box>
    </x-form>
@endsection
