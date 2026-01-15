<?php
/** @var \App\Models\MiscModel $model */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('crud.titles.editing', ['name' => $entity->name])  . ' - ' . __('entities.' . $name),
    'breadcrumbs' => (isset($entity) ? [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.edit'),
    ] : [
        __('crud.edit'),
    ]),
    'mainTitle' => false,
    'entity' => null,
    'centered' => true,
])

@section('content')
    @include('ads.top')
    <x-form
        method="PATCH"
        :action="[$name . '.update', $campaign, $entity->id]"
        files
        unsaved
        class="entity-form"
        id="entity-form"
        :extra="['data-max-fields' => ini_get('max_input_vars')]">
        <x-grid type="1/1">
            @include('cruds.forms._errors')
            <div class="nav-tabs-custom bg-base-100 p-4 rounded-xl flex flex-col gap-6">
                <div class="flex gap-2 items-center justify-between ">
                    <div class="overflow-x-auto">
                        <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                            <x-tab.tab target="entry" :default="true" :title="__('crud.fields.entry')"></x-tab.tab>

                            @includeIf($name . '.form._tabs', ['source' => null])
                            @if ($tabBoosted && config('services.stripe.enabled'))
                                <x-tab.tab target="premium" icon="premium" :title="auth()->user()->hasBoosterNomenclature() ? __('crud.tabs.boost') : __('crud.tabs.premium')"></x-tab.tab>
                            @endif
                            @if ($tabAttributes)
                                <x-tab.tab target="attributes" icon="attributes" :title="__('crud.tabs.attributes')"></x-tab.tab>
                            @endif
                            @if ($tabPermissions)
                                <x-tab.tab target="permissions" icon="permissions" :title="__('crud.tabs.permissions')"></x-tab.tab>
                            @endif
                        </ul>
                    </div>

                    <div class="">
                        @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane flex flex-col gap-5 {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
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

        @if(!empty($entity) && $campaign->hasEditingWarning())
            <input type="hidden" id="editing-keep-alive" data-url="{{ route('entities.keep-alive', [$campaign, $entity->id]) }}" />
        @endif
    </x-form>
@endsection

@include('editors.editor')

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($entity), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
