<?php
/**
* @var \App\Models\Timeline $timeline
* @var \App\Models\TimelineElement $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('timelines/elements.create.title', ['name' => $timeline->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($timeline->entity)->list(),
        Breadcrumb::show(),
        __('timelines/elements.create.title')
    ],
    'centered' => true,
])

@section('content')
    @include('partials.errors')

    <x-form :action="['timelines.timeline_elements.store', $campaign, $timeline]" id="timeline-element-form" files>
    <x-box>
        @include('timelines.elements._form', ['model' => null])
        <x-dialog.footer>
            <div class="form-element">
                <div class="submit-group">
                    <button class="btn2 btn-primary">{{ trans('crud.save') }}</button>
                </div>
            </div>
        </x-dialog.footer>
    </x-box>
    </x-form>
@endsection
