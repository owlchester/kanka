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

@section('fullpage-form')
    @env('shadow')
    @else
    {!! Form::model($model, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => [$name . '.update', $model->id], 'data-shortcut' => '1', 'class' => 'entity-form', 'id' => 'entity-form']) !!}
    @endenv
@endsection

@section('header-extra')
    @env('shadow')
    @else
    <div class="pull-right">
        @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
    </div>
    @endenv
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
            @if ($tabBoosted)
                <li class="{{ (request()->get('tab') == 'boost' ? ' active' : '') }}">
                    <a href="#form-boost" title="{{ trans('crud.tabs.boost') }}" data-toggle="tooltip">
                        <i class="fa fa-rocket"></i> <span class="hidden-xs">{{ __('crud.tabs.boost') }}</span>
                    </a>
                </li>
            @endif
            @if ($tabAttributes)
                <li class="{{ (request()->get('tab') == 'attributes' ? ' active' : '') }}">
                    <a href="#form-attributes" title="{{ trans('crud.tabs.attributes') }}" data-toggle="tooltip">
                        <span class="hidden-xs hidden-sm">{{ trans('crud.tabs.attributes') }}</span>
                        <i class="visible-xs visible-sm fa fa-th-list" title="{{ trans('crud.tabs.attributes') }}"></i>
                    </a>
                </li>
            @endif
            @if ($tabPermissions)
            <li class="{{ (request()->get('tab') == 'permission' ? ' active' : '') }}">
                <a href="#form-permission" title="{{ trans('crud.tabs.permissions') }}" data-toggle="tooltip">
                    <span class="hidden-xs hidden-sm">{{ trans('crud.tabs.permissions') }}</span>
                    <i class="visible-xs visible-sm fa fa-cog" title="{{ trans('crud.tabs.permissions') }}"></i>
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
            @if ($tabBoosted)
                <div class="tab-pane {{ (request()->get('tab') == 'boost' ? ' active' : '') }}" id="form-boost">
                    @include('cruds.forms._boost', ['source' => null])
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
    @env('shadow')
    @else
    {!! Form::close() !!}
    @endenv
@endsection
