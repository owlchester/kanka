<?php
/**
* @var \App\Models\Timeline $timeline
* @var \App\Models\TimelineEra $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('timelines/eras.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('timelines'), 'label' => \App\Facades\Module::plural(config('entities.ids.timeline'), __('entities.timelines'))],
        ['url' => $timeline->entity->url(), 'label' => $timeline->name],
        __('timelines/eras.edit.title', ['name' => $model->name])
    ]
])
@section('content')
    @include('partials.errors')
    {!! Form::model($model, [
        'route' => ['timelines.timeline_eras.update', $campaign, 'timeline' => $timeline, 'timeline_era' => $model],
        'method' => 'PATCH',
        'id' => 'timeline-era-form',
        'class' => 'ajax-subform',
        'data-shortcut' => 1,
        'data-maintenance' => 1,
    ]) !!}
    <x-box>
            @include('timelines.eras._form')
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

