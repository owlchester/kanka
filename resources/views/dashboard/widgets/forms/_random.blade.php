@inject('entityService', 'App\Services\EntityService')

@php
    $boosted = $campaign->boosted();
    $entityTypes = [];
    $entities = $entityService->campaign($campaign)->getEnabledEntitiesSorted(false);
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
                <div class="field-random-type required">
                    <label for="config-entity">
                        {{ __('menu_links.fields.random_type') }}
                    </label>
                    {!! Form::select('config[entity]', $entityTypes, (!empty($model) ? $model->conf('entity') : null), ['class' => 'form-control recent-entity-type']) !!}
                </div>

                <div class="field-recent-filters" style="@if (empty($model) || empty($model->conf('entity'))) display: none @else @endif">
                    <label>
                        {{ __('dashboard.widgets.recent.filters') }}
                        <a href="//docs.kanka.io/en/latest/guides/dashboard.html" target="_blank">
                            <i class="fa-solid fa-question-circle" title="{{ __('dashboard.widgets.helpers.filters') }}" data-toggle="tooltip" aria-hidden="true"></i>
                        </a>
                    </label>
                    {!! Form::text('config[filters]', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
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
