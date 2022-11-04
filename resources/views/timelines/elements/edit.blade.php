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
['url' => route('timelines.index'), 'label' => __('entities.timelines')],
['url' => $timeline->entity->url('show'), 'label' => $timeline->name],
__('timelines/elements.edit.title', ['name' => $model->name])
]
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')
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
            @include('partials.errors')

            {!! Form::model($model, ['route' => ['timelines.timeline_elements.update', 'timeline' => $timeline, 'timeline_element' => $model], 'method' => 'PATCH', 'id' => 'timeline-element-form', 'enctype' => 'multipart/form-data', 'class' => 'ajax-subform', 'data-shortcut' => 1]) !!}
            @include('timelines.elements._form')

            <div class="form-element">
                <div class="submit-group">
                    <button class="btn btn-success">{{ trans('crud.save') }}</button>
                    @includeWhen(!request()->ajax(), 'partials.or_cancel')
                </div>
                <div class="submit-animation" style="display: none;">
                    <button class="btn btn-success" disabled><i class="fa-solid fa-spinner fa-spin"></i></button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

    @if(!empty($model) && $campaignService->campaign()->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('timeline-elements.keep-alive', $model->id) }}" />
    @endif
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/ajax-subforms.js') }}" defer></script>
@endsection

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model])
@endsection