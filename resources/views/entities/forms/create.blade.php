<?php
    /**
     * @var \App\Models\EntityType $entityType
     * @var \App\Models\Campaign $campaign
     */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities.creator.title') . ' - ' . $entityType->name(),
    'breadcrumbs' => [
        ['url' => Breadcrumb::campaign($campaign)->entityType($entityType)->index(), 'label' => $entityType->plural()],
        __('crud.create'),
    ],
    'mainTitle' => false,
    'centered' => true,
])

@section('content')
    <x-form
        :action="['entities.store', $campaign, $entityType]"
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
                        <x-tab.tab target="entry" :default="true" :title="__('crud.tabs.overview')"></x-tab.tab>

                        @if (config('services.stripe.enabled'))
                            <x-tab.tab target="premium" icon="premium" :title="__('crud.tabs.premium')"></x-tab.tab>
                        @endif
                        <x-tab.tab target="attributes" icon="attributes" :title="__('entries/tabs.properties')"></x-tab.tab>

                        <x-tab.tab target="permissions" icon="permissions" :title="__('crud.tabs.permissions')"></x-tab.tab>

                        @if ((!empty($source) || !empty(old('copy_source_id'))) && $tabCopy)
                            <x-tab.tab target="copy" :title="__('crud.forms.copy_options')"></x-tab.tab>
                        @endif
                    </ul>
                </div>

                @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
            </div>

            <div class="tab-content">
                <div class="tab-pane pane-entry {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
                    <x-grid type="1/1">
                        @include('entities.forms.entry')
                    </x-grid>
                </div>

                @if (config('services.stripe.enabled'))
                    <div class="tab-pane pane-premium {{ (request()->get('tab') == 'premium' ? ' active' : '') }}" id="form-premium">
                        <x-grid type="1/1">
                            @include('cruds.forms._premium')
                        </x-grid>
                    </div>
                @endif
                @if ((!empty($source) || !empty(old('copy_source_id'))) && $tabCopy)
                    <div class="tab-pane pane-copy {{ (request()->get('tab') == 'copy' ? ' active' : '') }}" id="form-copy">
                        <x-grid type="1/1">
                            @include('cruds.forms._copy')
                        </x-grid>
                    </div>
                @endif
                <div class="tab-pane pane-attributes {{ (request()->get('tab') == 'attributes' ? ' active' : '') }}" id="form-attributes">
                    <x-grid type="1/1">
                        @include('cruds.forms._attributes')
                    </x-grid>
                </div>
                <div class="tab-pane pane-permissions {{ (request()->get('tab') == 'permissions' ? ' active' : '') }}" id="form-permissions">
                    <x-grid type="1/1">
                        @include('cruds.forms._permission')
                    </x-grid>
                </div>
            </div>
        </div>
        </x-grid>
    </x-form>
@endsection

@include('editors.editor')


@includeIf($entityType->pluralCode() . '.forms._tutorial')
