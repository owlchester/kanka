<?php
/** @var \App\Models\MiscModel $model */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('crud.titles.editing', ['name' => $model->name])  . ' - ' . __('entities.' . $name),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => __('entities.' . $name)],
        ['url' => route($name . '.show', $model->id), 'label' => $model->name],
        __('crud.edit'),
    ],
    'mainTitle' => false,
])
@inject('campaignService', 'App\Services\CampaignService')

@section('fullpage-form')
{!! Form::model($model, [
    'method' => 'PATCH',
    'enctype' => 'multipart/form-data',
    'route' => [$name . '.update', $model->id],
    'data-shortcut' => '1',
    'data-max-fields' => ini_get('max_input_vars'),
    'class' => 'entity-form' . (isset($horizontalForm) && $horizontalForm ? ' form-horizontal' : null),
    'id' => 'entity-form',
    'data-maintenance' => 1,
    'data-unload' => 1,
]) !!}
@endsection

@section('content')
    @include('cruds.forms._errors')

    <div class="nav-tabs-custom">
        <div class="pull-right">
            @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form', 'cost' => 6])
        </div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                <a href="#form-entry" title="{{ __('crud.fields.entry') }}" role="tab" aria-controls="form-entry">
                    {{ __('crud.fields.entry') }}
                </a>
            </li>
            @includeIf($name . '.form._tabs', ['source' => null])
            @if ($tabBoosted)
                <li role="presentation" class="{{ (request()->get('tab') == 'boost' ? ' active' : '') }}">
                    <a href="#form-boost" title="{{ __('crud.tabs.boost') }}" role="tab" aria-controls="form-boost">
                        <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                        <span class="hidden-xs hidden-sm">{{ __('crud.tabs.boost') }}</span>
                    </a>
                </li>
            @endif
            @if ($tabAttributes)
                <li role="presentation"  class="{{ (request()->get('tab') == 'attributes' ? ' active' : '') }}">
                    <a href="#form-attributes" title="{{ __('crud.tabs.attributes') }}" role="tab" aria-controls="form-attributes">
                        <i class="fa-solid fa-th-list" title="{{ __('crud.tabs.attributes') }}"></i>
                        <span class="hidden-xs hidden-sm">{{ __('crud.tabs.attributes') }}</span>
                    </a>
                </li>
            @endif
            @if ($tabPermissions)
            <li role="presentation"  class="{{ (request()->get('tab') == 'permission' ? ' active' : '') }}">
                <a href="#form-permissions" title="{{ __('crud.tabs.permissions') }}" role="tab" aria-controls="form-permissions">
                    <i class="fa-solid fa-cog" title="{{ __('crud.tabs.permissions') }}"></i>
                    <span class="hidden-xs hidden-sm">{{ __('crud.tabs.permissions') }}</span>
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
            <div class="tab-pane {{ (request()->get('tab') == 'permission' ? ' active' : '') }}" id="form-permissions">
                @include('cruds.forms._permission', ['source' => null])
            </div>
            @endif
        </div>
    </div>


    @if(!empty($model->entity) && $campaignService->campaign()->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('entities.keep-alive', $model->entity->id) }}" />
    @endif
@endsection

@include('editors.editor')


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
