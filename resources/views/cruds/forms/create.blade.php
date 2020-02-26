@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans($name . '.create.title'),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        trans('crud.create'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('fullpage-form')
    {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'route' => [$name . '.store'], 'data-shortcut' => '1', 'class' => 'entity-form', 'id' => 'entity-form']) !!}
@endsection

@section('content')
    @include('cruds.forms._errors')

    <div class="nav-tabs-custom">
        <div class="pull-right">
            @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
        </div>
        <ul class="nav nav-tabs">
            <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                <a href="#form-entry" title="{{ trans('crud.panels.entry') }}" data-toggle="tooltip">
                    {{ trans('crud.panels.entry') }}
                </a>
            </li>
            @includeIf($name . '.form._tabs', ['source' => $source])

            @if ($tabBoosted)
                <li class="{{ (request()->get('tab') == 'boost' ? ' active' : '') }}">
                    <a href="#form-boost" title="{{ trans('crud.tabs.boost') }}" data-toggle="tooltip">
                        <i class="fa fa-rocket"></i> <span class="hidden-xs">{{ __('crud.tabs.boost') }}</span>
                    </a>
                </li>
            @endif
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
                        <span class="hidden-xs hidden-sm">{{ trans('crud.tabs.attributes') }}</span>
                        <i class="visible-xs visible-sm fa fa-th-list" title="{{ trans('crud.tabs.attributes') }}"></i>
                    </a>
                </li>
            @endif
            @if ($tabPermissions)
            <li class="{{ (request()->get('tab') == 'permission' ? ' active' : '') }}">
                <a href="#form-permissions" title="{{ trans('crud.tabs.permissions') }}" data-toggle="tooltip">
                    <span class="hidden-xs hidden-sm">{{ trans('crud.tabs.permissions') }}</span>
                    <i class="visible-xs visible-sm fa fa-cog" title="{{ trans('crud.tabs.permissions') }}"></i>
                </a>
            </li>
            @endif
        </ul>

        <div class="tab-content">
            <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
                {{ csrf_field() }}
                @include($name . '.form._entry', ['source' => $source])
            </div>
            @includeIf($name . '.form._panes', ['source' => $source])

            @if ($tabBoosted)
                <div class="tab-pane {{ (request()->get('tab') == 'boost' ? ' active' : '') }}" id="form-boost">
                    @include('cruds.forms._boost', ['source' => $source])
                </div>
            @endif
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
