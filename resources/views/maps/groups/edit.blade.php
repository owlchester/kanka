<?php
/**
* @var \App\Models\Map $map
* @var \App\Models\MapGroup $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/groups.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('maps.index'), 'label' => __('maps.index.title')],
        ['url' => $map->entity->url('show'), 'label' => $map->name],
        ['url' => route('maps.map_groups.index', [$map]), 'label' => __('maps.panels.groups')],
        __('maps/groups.edit.title', ['name' => $model->name])
    ]
])

@section('content')
    {!! Form::model($model, ['route' => ['maps.map_groups.update', 'map' => $map, 'map_group' => $model], 'method' => 'PATCH', 'id' => 'map-group-form', 'enctype' => 'multipart/form-data', 'class' => 'ajax-subform']) !!}

    @if (request()->ajax())
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">
                {{ __('maps/groups.edit.title', ['name' => $model->name]) }}
            </h4>
        </div>
        <div class="modal-body">
    @else
        <div class="panel panel-default">
    @endif

            <div class="@if(!request()->ajax()) panel-body @endif">
                @include('partials.errors')
                @include('maps.groups._form')
            </div>

    @if (request()->ajax())
        </div>
        <div class="modal-footer">
            @include('maps.groups._actions')

            <div class="pull-left">
                @include('partials.footer_cancel')
            </div>
        </div>
    @else
            <div class="panel-footer text-right">
                @include('maps.groups._actions')
                <div class="pull-left">
                    @include('partials.footer_cancel')
                </div>
            </div>
        </div>
    @endif

    {!! Form::close() !!}
@endsection
