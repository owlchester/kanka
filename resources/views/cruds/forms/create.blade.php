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

@section('fullpage-form')
    {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'route' => [$name . '.store'], 'data-shortcut' => '1', 'class' => 'entity-form', 'id' => 'entity-form']) !!}
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
            @includeIf($name . '.form._tabs', ['source' => $source])

            @if (!empty($source) || !empty(old('copy_source_id')))
                <li class="{{ (request()->get('tab') == 'copy' ? ' active' : '') }}">
                    <a href="#form-copy" title="{{ trans('crud.forms.copy_options') }}" data-toggle="tooltip">
                        {{ trans('crud.forms.copy_options') }}
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
                <a href="#form-permissions" title="{{ trans('crud.tabs.permissions') }}" data-toggle="tooltip">
                    {{ trans('crud.tabs.permissions') }}
                </a>
            </li>
            @endif
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
            @if ($tabAttributes)
            <div class="tab-pane {{ (request()->get('tab') == 'attributes' ? ' active' : '') }}" id="form-attributes">
                @include('cruds.forms._attributes', ['source' => $source])
            </div>
            @endif
            @if ($tabPermissions)
            <div class="tab-pane {{ (request()->get('tab') == 'permission' ? ' active' : '') }}" id="form-permissions">
                @include('cruds.forms._permission', ['source' => $source])
            </div>
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@include('editors.editor')

@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection
