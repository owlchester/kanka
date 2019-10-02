<?php
/** @var \App\Models\MiscModel $model */
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans($name . '.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        ['url' => route($name . '.show', $model->id), 'label' => $model->name],
        trans('crud.update'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')
@inject('formService', 'App\Services\FormService')

@section('fullpage-form')
    {!! Form::model($model, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => [$name . '.update', $model->id], 'data-shortcut' => '1', 'class' => 'entity-form', 'id' => 'entity-form']) !!}
@endsection

@section('header-extra')
    <div class="pull-right">
        @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
    </div>
@endsection

@section('content')
    @include('cruds.forms._errors')

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                <a href="#form-entry" title="{{ trans('crud.panels.entry') }}" data-toggle="tooltip">
                    {{ trans('crud.panels.entry') }}
                </a>
            </li>
            @includeIf($name . '.form._tabs', ['source' => null])
            @if ($campaign->campaign()->boosted())
                <li class="{{ (request()->get('tab') == 'tooltip' ? ' active' : '') }}">
                    <a href="#form-tooltip" title="{{ trans('crud.tabs.tooltip') }}" data-toggle="tooltip">
                        <i class="fa fa-rocket"></i> {{ __('crud.tabs.tooltip') }}
                    </a>
                </li>
            @endif
            @if ($tabAttributes)
                <li class="{{ (request()->get('tab') == 'attributes' ? ' active' : '') }}">
                    <a href="#form-attributes" title="{{ trans('crud.tabs.attributes') }}" data-toggle="tooltip">
                        {{ trans('crud.tabs.attributes') }}
                    </a>
                </li>
            @endif
            @if ($tabPermissions)
            <li class="{{ (request()->get('tab') == 'permission' ? ' active' : '') }}">
                <a href="#form-permission" title="{{ trans('crud.tabs.permissions') }}" data-toggle="tooltip">
                    {{ trans('crud.tabs.permissions') }}
                </a>
            </li>
            @endif
        </ul>

        <div class="tab-content">
            <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
                {{ csrf_field() }}
                @include($name . '.form._entry', ['source' => null])
            </div>
            @includeIf($name . '.form._panes', ['source' => null])
            @if ($campaign->campaign()->boosted())
                <div class="tab-pane {{ (request()->get('tab') == 'tooltip' ? ' active' : '') }}" id="form-tooltip">
                    @include('cruds.forms._tooltip', ['source' => null])
                </div>
            @endif
            @if ($tabAttributes)
                <div class="tab-pane {{ (request()->get('tab') == 'attributes' ? ' active' : '') }}" id="form-attributes">
                    @include('cruds.forms._attributes', ['source' => null])
                </div>
            @endif
            @if ($tabPermissions)
            <div class="tab-pane {{ (request()->get('tab') == 'permission' ? ' active' : '') }}" id="form-permission">
                @include('cruds.forms._permission', ['source' => null])
            </div>
            @endif
        </div>
    </div>
@endsection

@include('editors.editor')


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection