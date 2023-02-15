<?php
/**
* @var \App\Models\Timeline $timeline
* @var \App\Models\TimelineEra $model
*/
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('timelines/eras.create.title', ['name' => $timeline->name]),
    'description' => '',
    'breadcrumbs' => [
    ['url' => route('timelines.index'), 'label' => __('entities.timelines')],
    ['url' => $timeline->entity->url('show'), 'label' => $timeline->name],
    __('timelines/eras.create.title')
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::open([
        'route' => ['timelines.timeline_eras.store', $timeline],
        'method' => 'POST',
        'id' => 'timeline-era-form',
        'class' => 'ajax-subform',
        'data-shortcut' => 1,
        'data-maintenance' => 1,
    ]) !!}
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('timelines/eras.create.title', ['name' => $timeline->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('timelines.eras._form', ['model' => null])
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
