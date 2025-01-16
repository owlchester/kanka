@inject('entityTypeService', 'App\Services\EntityTypeService')


@php
    $boosted = $campaign->boosted();

    $entityTypes = $entityTypeService
        ->campaign($campaign)
        ->exclude([config('entities.ids.bookmark')])
        ->prepend(['' => __('dashboard.widgets.random.type.all')])
        ->toSelect();
@endphp

<div class="nav-tabs-custom">
    <ul class="nav-tabs bg-base-300 !p-1 rounded" role="tablist">
        <li class="active">
            <a data-toggle="tab" href="#setup-{{ $mode }}">
                {{ __('dashboard.widgets.tabs.setup') }}
            </a>
        </li>
        <li>
            <a class="" data-toggle="tab" href="#advanced-{{ $mode }}">
                {{ __('dashboard.widgets.tabs.advanced') }}
            </a>
        </li>
    </ul>

    <div class="tab-content p-4">
        <div id="setup-{{ $mode }}" class="tab-pane fade in active">
            <x-grid>
                <x-forms.field field="random-type" :required="true" :label="__('bookmarks.fields.random_type')">
                    <x-forms.select name="entity_type_id" :options="$entityTypes" :selected="$model->entityType->id ?? null" class="w-full recent-entity-type" />
                </x-forms.field>

                <x-forms.field field="recent-filters"
                    :hidden="empty($model) || empty($model->entityType)"
                    :label="__('dashboard.widgets.recent.filters')"
                    tooltip
                    link="https://docs.kanka.io/en/latest/guides/dashboard.html"
                    :helper="__('dashboard.widgets.helpers.filters')">
                    <input type="text" name="config[filters]" value="{{ old('config[filters]', $model?->config['filters'] ?? null) }}" maxlength="191" class="w-full" id="config[filters]" placeholder="" />
                </x-forms.field>

                @include('dashboard.widgets.forms._name', ['random' => true])

                @include('dashboard.widgets.forms._width')

                @include('dashboard.widgets.forms._tags')
                @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
            </x-grid>
        </div>

        <div id="advanced-{{ $mode }}" class="tab-pane fade in">
            @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')

            <x-grid>
                @include('dashboard.widgets.forms._header_select')
                @include('dashboard.widgets.forms._related')
                @include('dashboard.widgets.forms._class')
            </x-grid>
        </div>
    </div>
</div>
