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
        ['url' => Breadcrumb::index('timelines'), 'label' => \App\Facades\Module::plural(config('entities.ids.timeline'), __('entities.timelines'))],
        ['url' => $timeline->entity->url(), 'label' => $timeline->name],
        __('timelines/elements.create.title')
    ]
])

@section('content')
    @include('partials.errors')
    {!! Form::open(['route' => ['timelines.timeline_elements.store', $timeline], 'method' => 'POST', 'id' => 'timeline-element-form', 'enctype' => 'multipart/form-data', 'class' => 'ajax-subform', 'data-shortcut' => 1, 'data-maintenance' => 1]) !!}
    <x-box>
        @include('timelines.elements._form', ['model' => null])
        <x-box.footer>
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
        </x-box.footer>
    </x-box>
    {!! Form::close() !!}
@endsection
