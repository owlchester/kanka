<?php
/**
* @var \App\Models\Timeline $timeline
* @var \App\Models\TimelineEra $model
*/
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('timelines/eras.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('timelines.index'), 'label' => __('entities.timelines')],
        ['url' => $timeline->entity->url('show'), 'label' => $timeline->name],
        __('timelines/eras.edit.title', ['name' => $model->name])
    ]
])
@inject('campaignService', 'App\Services\CampaignService')
@section('content')
    @include('partials.errors')
    {!! Form::model($model, [
        'route' => ['timelines.timeline_eras.update', 'timeline' => $timeline, 'timeline_era' => $model],
        'method' => 'PATCH',
        'id' => 'timeline-era-form',
        'class' => 'ajax-subform',
        'data-shortcut' => 1
    ]) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            @include('timelines.eras._form')
        </div>
        <div class="panel-footer">

            @include('partials.footer_cancel', ['ajax' => null])
            <div class="form-era pull-right">
                <div class="submit-group">
                    <button class="btn btn-success">{{ __('crud.save') }}</button>
                </div>
                <div class="submit-animation" style="display: none;">
                    <button class="btn btn-success" disabled><i class="fa-solid fa-spinner fa-spin"></i></button>
                </div>
            </div>

        </div>
    </div>
    @if (!empty($from))
        <input type="hidden" name="from" value="{{ $from }}">
    @endif
    {!! Form::close() !!}
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/ajax-subforms.js') }}" defer></script>
@endsection
