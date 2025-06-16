<?php
/**
* @var \App\Models\Timeline $timeline
* @var \App\Models\TimelineEra $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('timelines/eras.create.title', ['name' => $timeline->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($timeline->entity)->list(),
        Breadcrumb::show(),
        __('timelines/eras.create.title')
    ],
    'centered' => true,
])
@section('content')
    @include('partials.errors')

    <x-form :action="['timelines.timeline_eras.store', $campaign, $timeline]" id="timeline-era-form">
        <x-box>
            @include('timelines.eras._form', ['model' => null])

            <x-dialog.footer>
                <div class="form-era">
                    <div class="submit-group">
                        <button class="btn2 btn-primary">{{ __('crud.save') }}</button>
                    </div>
                </div>
            </x-dialog.footer>
        </x-box>
        @if (!empty($from))
            <input type="hidden" name="from" value="{{ $from }}">
        @endif
    </x-form>
@endsection
