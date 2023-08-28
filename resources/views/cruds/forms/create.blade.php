@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => $title,
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => $plural],
        __('crud.create'),
    ],
    'mainTitle' => false,
])

@section('fullpage-form')
{!! Form::open([
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    'route' => [$name . '.store', $campaign],
    'data-shortcut' => '1',
    'class' => 'entity-form',
    'id' => 'entity-form',
    'data-max-fields' => ini_get('max_input_vars'),
    'data-unload' => 1,
    'data-maintenance' => 1,
]) !!}
@endsection

@section('content')
    @include('cruds.forms._errors')

    <div class="nav-tabs-custom">
        <div class="flex gap-2 items-center ">
            <div class="grow overflow-x-auto">
                <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                    <x-tab.tab target="entry" :default="true" :title="__('crud.fields.entry')"></x-tab.tab>

                    @includeIf($name . '.form._tabs', ['source' => $source])

                    @if ($tabBoosted)
                        <x-tab.tab target="premium" icon="premium" :title="auth()->check() && auth()->user()->hasBoosterNomenclature() ? __('crud.tabs.boost') : __('crud.tabs.premium')"></x-tab.tab>
                    @endif
                    @if ($tabAttributes)
                        <x-tab.tab target="attributes" icon="fa-solid fa-th-list" :title="__('crud.tabs.attributes')"></x-tab.tab>
                    @endif
                    @if ($tabPermissions)
                        <x-tab.tab target="permissions" icon="fa-solid fa-cog" :title="__('crud.tabs.permissions')"></x-tab.tab>
                    @endif

                    @if ((!empty($source) || !empty(old('copy_source_id'))) && $tabCopy)
                        <x-tab.tab target="copy" :title="__('crud.forms.copy_options')"></x-tab.tab>
                    @endif
                </ul>
            </div>

            @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
        </div>

        <div class="tab-content bg-base-100 p-4 rounded-bl rounded-br">
            <div class="tab-pane pane-entry {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
                {{ csrf_field() }}
                @include($name . '.form._entry', ['source' => $source])
            </div>
            @includeIf($name . '.form._panes', ['source' => $source])

            @if ($tabBoosted)
                <div class="tab-pane pane-premium {{ (request()->get('tab') == 'premium' ? ' active' : '') }}" id="form-premium">
                    @include('cruds.forms._premium', ['source' => $source])
                </div>
            @endif
            @if ((!empty($source) || !empty(old('copy_source_id'))) && $tabCopy)
                <div class="tab-pane pane-copy {{ (request()->get('tab') == 'copy' ? ' active' : '') }}" id="form-copy">
                    @include('cruds.forms._copy', ['source' => $source])
                </div>
            @endif
            @if ($tabAttributes)
            <div class="tab-pane pane-attributes {{ (request()->get('tab') == 'attributes' ? ' active' : '') }}" id="form-attributes">
                @include('cruds.forms._attributes', ['source' => $source])
            </div>
            @endif
            @if ($tabPermissions)
            <div class="tab-pane pane-permissions {{ (request()->get('tab') == 'permissions' ? ' active' : '') }}" id="form-permissions">
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
