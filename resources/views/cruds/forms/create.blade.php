@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => $title,
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => $plural],
        __('crud.create'),
    ]
])
@inject('campaignService', 'App\Services\CampaignService')

@section('fullpage-form')
{!! Form::open([
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    'route' => [$name . '.store'],
    'data-shortcut' => '1',
    'class' => 'entity-form' . (isset($horizontalForm) && $horizontalForm ? ' form-horizontal' : null),
    'id' => 'entity-form',
    'data-max-fields' => ini_get('max_input_vars'),
    'data-unload' => 1,
    'data-maintenance' => 1,
]) !!}
@endsection

@section('content')
    @include('cruds.forms._errors')

    <div class="nav-tabs-custom">
        <div class="pull-right">
            @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form', 'cost' => 15])
        </div>
        <ul class="nav-tabs border-none overflow-hidden">
            <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                <a href="#form-entry" title="{{ __('crud.fields.entry') }}">
                    {{ __('crud.fields.entry') }}
                </a>
            </li>
            @includeIf($name . '.form._tabs', ['source' => $source])

            @if ($tabBoosted)
                <li class="{{ (request()->get('tab') == 'premium' ? ' active' : '') }}">
                    <a href="#form-premium" title="{{ __('crud.tabs.premium') }}">
                        @if (auth()->check() && auth()->user()->hasBoosterNomenclature())
                            <x-icon class="premium"></x-icon>
                            <span class="hidden-xs hidden-sm">{{ __('crud.tabs.boost') }}</span>
                        @else
                            <x-icon class="premium"></x-icon>
                            <span>{{ __('crud.tabs.premium') }}</span>
                        @endif
                    </a>
                </li>
            @endif
            @if ($tabAttributes)
                <li class="{{ (request()->get('tab') == 'attributes' ? ' active' : '') }}">
                    <a href="#form-attributes" title="{{ __('crud.tabs.attributes') }}">
                        <i class="fa-solid fa-th-list" aria-hidden="true" title="{{ __('crud.tabs.attributes') }}"></i>
                        <span class="hidden-xs hidden-sm">{{ __('crud.tabs.attributes') }}</span>
                    </a>
                </li>
            @endif
            @if ($tabPermissions)
            <li class="{{ (request()->get('tab') == 'permission' ? ' active' : '') }}">
                <a href="#form-permissions" title="{{ __('crud.tabs.permissions') }}">
                    <i class="fa-solid fa-cog" aria-hidden="true" title="{{ __('crud.tabs.permissions') }}"></i>
                    <span class="hidden-xs hidden-sm">{{ __('crud.tabs.permissions') }}</span>
                </a>
            </li>
            @endif
            @if ((!empty($source) || !empty(old('copy_source_id'))) && $tabCopy)
                <li class="{{ (request()->get('tab') == 'copy' ? ' active' : '') }}">
                    <a href="#form-copy" title="{{ __('crud.forms.copy_options') }}">
                        {{ __('crud.forms.copy_options') }}
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
                <div class="tab-pane {{ (request()->get('tab') == 'premium' ? ' active' : '') }}" id="form-premium">
                    @include('cruds.forms._premium', ['source' => $source])
                </div>
            @endif
            @if ((!empty($source) || !empty(old('copy_source_id'))) && $tabCopy)
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

@includeIf($name . '.forms._tutorial')
