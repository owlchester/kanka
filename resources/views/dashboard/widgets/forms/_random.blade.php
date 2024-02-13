@inject('entityService', 'App\Services\EntityService')

@php
    $boosted = $campaign->boosted();
    $entityTypes = ['' => __('dashboard.widgets.random.type.all')];

    $entities = $entityService->campaign($campaign)->getEnabledEntitiesSorted(false, ['bookmarks']);
    $entityTypes = array_merge($entityTypes, $entities);
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
                    {!! Form::select('config[entity]', $entityTypes, (!empty($model) ? $model->conf('entity') : null), ['class' => ' recent-entity-type']) !!}
                </x-forms.field>

                <x-forms.field field="recent-filters"
                    :hidden="empty($model) || empty($model->conf('entity'))"
                    :label="__('dashboard.widgets.recent.filters')"
                    :tooltip="true"
                    link="https://docs.kanka.io/en/latest/guides/dashboard.html"
                    :helper="__('dashboard.widgets.helpers.filters')">
                    {!! Form::text('config[filters]', null, ['class' => '', 'maxlength' => 191]) !!}
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
