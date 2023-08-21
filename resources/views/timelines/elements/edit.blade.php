<?php
/**
* @var \App\Models\Timeline $timeline
* @var \App\Models\TimelineElement $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('timelines/elements.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($timeline->entity)->list(),
        Breadcrumb::show($timeline),
        __('timelines/elements.edit.title', ['name' => $model->name])
    ]
])


@section('content')
    @include('partials.errors')

    {!! Form::model($model, ['route' => ['timelines.timeline_elements.update', $campaign, 'timeline' => $timeline, 'timeline_element' => $model], 'method' => 'PATCH', 'id' => 'timeline-element-form', 'enctype' => 'multipart/form-data', 'class' => 'ajax-subform', 'data-shortcut' => 1, 'data-maintenance' => 1]) !!}
    <x-box>
        @include('timelines.elements._form')

        <x-dialog.footer>
            <div class="form-element">
                <div class="submit-group">
                    <button class="btn2 btn-primary">{{ trans('crud.save') }}</button>
                </div>
            </div>
        </x-dialog.footer>
    </x-box>
    {!! Form::close() !!}

    @if(!empty($model) && $campaign->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('timeline-elements.keep-alive', [$campaign, $model->id]) }}" />
    @endif
@endsection

@section('scripts')
    @parent
@endsection

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
