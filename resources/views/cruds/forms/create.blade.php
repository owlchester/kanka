@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans($name . '.create.title'),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        trans('crud.create'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')
@inject('formService', 'App\Services\FormService')

@section('header-extra')
    {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'route' => [$name . '.store'], 'data-shortcut' => '1', 'class' => 'entity-form', 'id' => 'entity-form']) !!}

    <div class="pull-right">
        @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
    </div>
@endsection

@section('content')
    @include('partials.errors')

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                <a href="#form-entry" title="{{ trans('crud.panels.entry') }}" data-toggle="tooltip">
                    {{ trans('crud.panels.entry') }}
                </a>
            </li>
            @includeIf($name . '.form._tabs', ['source' => $source])

            @if (!empty($source) || !empty(old('copy_source_id')))
                <li class="{{ (request()->get('tab') == 'copy' ? ' active' : '') }}">
                    <a href="#form-copy" title="{{ trans('crud.forms.copy_options') }}" data-toggle="tooltip">
                        {{ trans('crud.forms.copy_options') }}
                    </a>
                </li>
            @endif
            <li class="{{ (request()->get('tab') == 'permission' ? ' active' : '') }}">
                <a href="#form-permission" title="{{ trans('crud.tabs.permissions') }}" data-toggle="tooltip">
                    {{ trans('crud.tabs.permissions') }}
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
                {{ csrf_field() }}
                @include($name . '.form._entry', ['source' => $source])
            </div>
            @includeIf($name . '.form._panes', ['source' => null])

            @if (!empty($source) || !empty(old('copy_source_id')))
                <div class="tab-pane {{ (request()->get('tab') == 'copy' ? ' active' : '') }}" id="form-copy">
                    @include('cruds.forms._copy', ['source' => $source])
                </div>
            @endif
            <div class="tab-pane {{ (request()->get('tab') == 'permission' ? ' active' : '') }}" id="form-permission">
                @include('cruds.forms._permission', ['source' => $source])
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@include('editors.editor')