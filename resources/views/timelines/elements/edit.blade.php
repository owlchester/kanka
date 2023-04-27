<?php
/**
* @var \App\Models\Timeline $timeline
* @var \App\Models\TimelineElement $model
*/
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('timelines/elements.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('timelines'), 'label' => \App\Facades\Module::plural(config('entities.ids.timeline'), __('entities.timelines'))],
        ['url' => $timeline->entity->url(), 'label' => $timeline->name],
        __('timelines/elements.edit.title', ['name' => $model->name])
    ]
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')

    {!! Form::model($model, ['route' => ['timelines.timeline_elements.update', 'timeline' => $timeline, 'timeline_element' => $model], 'method' => 'PATCH', 'id' => 'timeline-element-form', 'enctype' => 'multipart/form-data', 'class' => 'ajax-subform', 'data-shortcut' => 1, 'data-maintenance' => 1]) !!}
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('timelines/elements.edit.title', ['name' => $model->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('timelines.elements._form')
        </div>
        <div class="panel-footer">
            <a href="{{ route('timelines.show', $timeline) }}" class="btn btn-default">
                {{ __('crud.cancel') }}
            </a>

            <div class="form-element pull-right">
                <div class="submit-group">
                    <button class="btn btn-success">{{ trans('crud.save') }}</button>
                </div>
                <div class="submit-animation" style="display: none;">
                    <button class="btn btn-success" disabled><i class="fa-solid fa-spinner fa-spin"></i></button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @if(!empty($model) && $campaignService->campaign()->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('timeline-elements.keep-alive', $model->id) }}" />
    @endif
@endsection

@section('scripts')
    @parent
    @vite(['resources/js/ajax-subforms.js'])
@endsection

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
