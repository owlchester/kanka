<?php
/** @var \App\Models\MiscModel $model */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __($name . '.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
        ['url' => route($name . '.show', $model->id), 'label' => $model->name],
        __('crud.edit'),
    ],
    'mainTitle' => false,
])
@inject('campaign', 'App\Services\CampaignService')

@section('fullpage-form')
{!! Form::model($model, [
    'method' => 'PATCH',
    'enctype' => 'multipart/form-data',
    'route' => [$name . '.update', $model->id],
    'data-shortcut' => '1',
    'data-max-fields' => ini_get('max_input_vars'),
    'class' => 'entity-form' . (isset($horizontalForm) && $horizontalForm ? ' form-horizontal' : null),
    'id' => 'entity-form'
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
                <a href="#form-entry" title="{{ __('crud.panels.entry') }}" role="tab" aria-controls="form-entry">
                    {{ __('crud.panels.entry') }}
                </a>
            </li>
            @includeIf($name . '.form._tabs', ['source' => null])
            @if ($tabBoosted)
                <li role="presentation" class="{{ (request()->get('tab') == 'boost' ? ' active' : '') }}">
                    <a href="#form-boost" title="{{ __('crud.tabs.boost') }}" role="tab" aria-controls="form-boost">
                        <i class="fa-solid fa-rocket"></i>
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
                <a href="#form-permission" title="{{ __('crud.tabs.permissions') }}" role="tab" aria-controls="form-permission">
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
            <div class="tab-pane {{ (request()->get('tab') == 'permission' ? ' active' : '') }}" id="form-permission">
                @include('cruds.forms._permission', ['source' => null])
            </div>
            @endif
        </div>
    </div>


    @if(!empty($model->entity) && $campaign->campaign()->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('entities.keep-alive', $model->entity->id) }}" />
    @endif
@endsection

@include('editors.editor')


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@section('modals')
    @parent
    @if(!empty($editingUsers) && !empty($model->entity))
        <div class="modal" id="entity-edit-warning" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">{{ __('entities/story.warning.editing.title') }}</h4>
                    </div>
                    <div class="modal-body modal-ajax-body">
                        <p>
                            {{ __('entities/story.warning.editing.description') }}

                        </p>
                        <ul>
                            @foreach ($editingUsers as $user)
                                <li class="user-id-{{ $user->id }}">{{ __('entities/story.warning.editing.user', ['user' => $user->name, 'since' => \Carbon\Carbon::createFromTimeString($user->pivot->created_at)->diffForHumans()]) }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-body modal-spinner-body text-center" style="display: none">
                        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" id="entity-edit-warning-back" data-url="{{ url()->previous() }}">
                            {{ __('entities/story.warning.editing.back') }}
                        </button>

                        <button type="button" class="btn btn-warning" id="entity-edit-warning-ignore" data-url="{{ route('entities.confirm-editing', $model->entity) }}">
                            {{ __('entities/story.warning.editing.ignore') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
