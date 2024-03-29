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
        Breadcrumb::entity($timeline->entity)->list(),
        Breadcrumb::show($timeline),
        __('timelines/eras.create.title')
    ],
    'centered' => true,
])
@section('content')
    @include('partials.errors')

    {!! Form::open([
        'route' => ['timelines.timeline_eras.store', $campaign, $timeline],
        'method' => 'POST',
        'id' => 'timeline-era-form',
        'class' => 'ajax-subform',
        'data-shortcut' => 1,
        'data-maintenance' => 1,
    ]) !!}
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
    {!! Form::close() !!}
@endsection
