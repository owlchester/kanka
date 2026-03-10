@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => $title,
    'breadcrumbs' => [
        ['url' => Breadcrumb::campaign($campaign)->index($name), 'label' => $plural],
        __('crud.create'),
    ],
    'mainTitle' => false,
    'centered' => true,
])

@section('content')
    @include('ads.top')

    @if ($entityType->isCharacter() && request()->get('from') === 'onboarding')
        <div class="flex flex-col gap-2 bg-primary text-primary-content p-4 rounded-xl mb-6">
            <p class="text-lg font-semibold mb-2">
                {{ __('onboarding/characters.title') }}
            </p>
            <p>
                {{ __('onboarding/characters.text') }}
            </p>
            <p>
                {{ __('onboarding/characters.finisher') }}
            </p>
        </div>
    @elseif ($entityType->isLocation() && request()->get('from') === 'onboarding')
        <div class="flex flex-col gap-2 bg-primary text-primary-content p-4 rounded-xl mb-6">
            <p class="text-lg font-semibold mb-2">
                {{ __('onboarding/locations.title') }}
            </p>
            <p>
                {{ __('onboarding/locations.text') }}
            </p>
            <p>
                {{ __('onboarding/locations.finisher') }}
            </p>
        </div>
    @endif
    <x-form
        :action="[$name . '.store', $campaign]"
        files
        unsaved
        class="entity-form"
        id="entity-form"
        :extra="['data-max-fields' => ini_get('max_input_vars')]">

        <x-grid type="1/1">
            @include('cruds.forms._errors')

            <div class="nav-tabs-custom bg-base-100 p-4 rounded-xl flex flex-col gap-6 relative">
                <div class="flex gap-2 items-center justify-between sticky z-10 top-12 bg-base-100">
                    <div class="overflow-x-auto">
                        <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                            <x-tab.tab target="entry" :default="true" :title="__('entries/tabs.identity')"></x-tab.tab>

                            @includeIf($name . '.form._tabs')

                            @if ($tabBoosted && config('services.stripe.enabled'))
                                <x-tab.tab target="premium" icon="premium" :title="__('crud.tabs.premium')"></x-tab.tab>
                            @endif
                            @if ($tabAttributes)
                                <x-tab.tab target="attributes" icon="attributes" :title="__('entries/tabs.properties')"></x-tab.tab>
                            @endif
                            @if ($tabPermissions)
                                <x-tab.tab target="permissions" icon="permissions" :title="__('crud.tabs.permissions')"></x-tab.tab>
                            @endif

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
                            @include($name . '.form._entry')
                        </x-grid>
                    </div>
                    @includeIf($name . '.form._panes')

                    @if ($tabBoosted && config('services.stripe.enabled'))
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
                    @if ($tabAttributes)
                        <div class="tab-pane pane-attributes {{ (request()->get('tab') == 'attributes' ? ' active' : '') }}" id="form-attributes">
                            <x-grid type="1/1">
                                @include('cruds.forms._attributes')
                            </x-grid>
                        </div>
                    @endif
                    @if ($tabPermissions)
                        <div class="tab-pane pane-permissions {{ (request()->get('tab') == 'permissions' ? ' active' : '') }}" id="form-permissions">
                            <x-grid type="1/1">
                                @include('cruds.forms._permission')
                            </x-grid>
                        </div>
                    @endif
                </div>
            </div>
        </x-grid>
    </x-form>
@endsection

@include('editors.editor')


@includeIf($name . '.forms._tutorial')
