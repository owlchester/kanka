<?php
/** @var \App\Models\MiscModel $model */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('crud.titles.editing', ['name' => $model->name])  . ' - ' . __('entities.' . $name),
    'breadcrumbs' => (isset($entity) ? [
        Breadcrumb::entity($entity ?? $model->entity)->list(),
        Breadcrumb::show(),
        __('crud.edit'),
    ] : [
        __('crud.edit'),
    ]),
    'mainTitle' => false,
    'centered' => true,
])

@section('content')
    <x-form
        method="PATCH"
        :action="[$name . '.update', $campaign, $model->id]"
        files
        unsaved
        class="entity-form"
        id="entity-form"
        :extra="['data-max-fields' => ini_get('max_input_vars')]">
        <x-grid type="1/1">
            @include('cruds.forms._errors')

            <div class="nav-tabs-custom ">
                <div class="flex gap-2 items-center ">
                    <div class="grow overflow-x-auto">
                        <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                            <x-tab.tab target="entry" :default="true" :title="__('crud.fields.entry')"></x-tab.tab>

                            @includeIf($name . '.form._tabs', ['source' => null])
                            @if ($tabBoosted && config('services.stripe.enabled'))
                                <x-tab.tab target="premium" icon="premium" :title="auth()->check() && auth()->user()->hasBoosterNomenclature() ? __('crud.tabs.boost') : __('crud.tabs.premium')"></x-tab.tab>
                            @endif
                            @if ($tabAttributes)
                                <x-tab.tab target="attributes" icon="fa-solid fa-th-list" :title="__('crud.tabs.attributes')"></x-tab.tab>
                            @endif
                            @if ($tabPermissions)
                                <x-tab.tab target="permissions" icon="fa-solid fa-cog" :title="__('crud.tabs.permissions')"></x-tab.tab>
                            @endif
                        </ul>
                    </div>

                    <div class="">
                        @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
                    </div>
                </div>

                <div class="tab-content bg-base-100 p-4 rounded-bl rounded-br">
                    <div class="tab-pane flex flex-col gap-5 {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
                        {{ csrf_field() }}
                        @include($name . '.form._entry', ['source' => null])
                    </div>
                    @includeIf($name . '.form._panes', ['source' => null])
                    @if ($tabBoosted && config('services.stripe.enabled'))
                        <div class="tab-pane flex flex-col gap-5 {{ (request()->get('tab') == 'premium' ? ' active' : '') }}" id="form-premium">
                            @include('cruds.forms._premium', ['source' => null])
                        </div>
                    @endif
                    @if ($tabAttributes)
                        <div class="tab-pane flex flex-col gap-5 {{ (request()->get('tab') == 'attributes' ? ' active' : '') }}" id="form-attributes">
                            @include('cruds.forms._attributes', ['source' => null])
                        </div>
                    @endif
                    @if ($tabPermissions)
                        <div class="tab-pane flex flex-col gap-5 {{ (request()->get('tab') == 'permission' ? ' active' : '') }}" id="form-permissions">
                            @include('cruds.forms._permission', ['source' => null])
                        </div>
                    @endif
                </div>
            </div>
        </x-grid>

        @if(!empty($model->entity) && $campaign->hasEditingWarning())
            <input type="hidden" id="editing-keep-alive" data-url="{{ route('entities.keep-alive', [$campaign, $model->entity->id]) }}" />
        @endif
    </x-form>
@endsection

@include('editors.editor')

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model->entity), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
