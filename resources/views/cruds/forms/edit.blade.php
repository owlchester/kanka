<?php
/** @var \App\Models\MiscModel $model */
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __($name . '.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => __($name . '.index.title')],
        ['url' => route($name . '.show', $model->id), 'label' => $model->name],
        __('crud.edit'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('fullpage-form')
    @env('shadow')
    @else
    {!! Form::model($model, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => [$name . '.update', $model->id], 'data-shortcut' => '1', 'class' => 'entity-form', 'id' => 'entity-form']) !!}
    @endenv
@endsection

@section('content')
    @include('cruds.forms._errors')

    <div class="nav-tabs-custom">
        @env('shadow')
        @else
            <div class="pull-right">
                @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
            </div>
        @endenv
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                <a href="#form-entry" title="{{ __('crud.panels.entry') }}" role="tab" data-toggle="tooltip" aria-controls="form-entry">
                    {{ __('crud.panels.entry') }}
                </a>
            </li>
            @includeIf($name . '.form._tabs', ['source' => null])
            @if ($tabBoosted)
                <li role="presentation" class="{{ (request()->get('tab') == 'boost' ? ' active' : '') }}">
                    <a href="#form-boost" title="{{ __('crud.tabs.boost') }}" role="tab" data-toggle="tooltip" aria-controls="form-boost">
                        <i class="fa fa-rocket"></i> <span class="hidden-xs">{{ __('crud.tabs.boost') }}</span>
                    </a>
                </li>
            @endif
            @if ($tabAttributes)
                <li role="presentation"  class="{{ (request()->get('tab') == 'attributes' ? ' active' : '') }}">
                    <a href="#form-attributes" title="{{ __('crud.tabs.attributes') }}" role="tab" data-toggle="tooltip" aria-controls="form-attributes">
                        <span class="hidden-xs hidden-sm">{{ __('crud.tabs.attributes') }}</span>
                        <i class="visible-xs visible-sm fa fa-th-list" title="{{ __('crud.tabs.attributes') }}"></i>
                    </a>
                </li>
            @endif
            @if ($tabPermissions)
            <li role="presentation"  class="{{ (request()->get('tab') == 'permission' ? ' active' : '') }}">
                <a href="#form-permission" title="{{ __('crud.tabs.permissions') }}" role="tab" data-toggle="tooltip" aria-controls="form-permission">
                    <span class="hidden-xs hidden-sm">{{ __('crud.tabs.permissions') }}</span>
                    <i class="visible-xs visible-sm fa fa-cog" title="{{ __('crud.tabs.permissions') }}"></i>
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
