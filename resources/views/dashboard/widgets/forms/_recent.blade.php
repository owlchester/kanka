@inject('entityService', 'App\Services\EntityService')
@php
    $advancedFilters = [
        '' => '',
        'unmentioned' => __('dashboard.widgets.recent.advanced_filters.unmentioned'),
        'mentionless' => __('dashboard.widgets.recent.advanced_filters.mentionless'),
    ];
    $boosted = $campaignService->campaign()->boosted();
    $entityTypes = ['' => 'All'];
    $entities = $entityService->campaign($campaignService->campaign())->getEnabledEntitiesSorted(false);
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
                <div class="field-entity-type required">
                    <label for="config-entity">
                        {{ __('crud.fields.entity_type') }}
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

                @include('dashboard.widgets.forms._tags')

                <div class="field-advanced-filters">
                    <label>{{ __('dashboard.widgets.recent.advanced_filter') }}</label>
                    {!! Form::select('config[adv_filter]', $advancedFilters, null, ['class' => 'form-control']) !!}
                </div>

                <div class="field-singular col-span-2">
                    {!! Form::hidden('config[singular]', 0) !!}
                    <div class="checkbox" data-toggle="collapse" data-target="#widget-advanced">
                        <label>
                            {!! Form::checkbox('config[singular]', 1, (!empty($model) ? $model->conf('singular') : null)) !!}

                            {{ __('dashboard.widgets.recent.singular') }}
                            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('dashboard.widgets.recent.help') }}" data-toggle="tooltip" aria-hidden="true"></i>
                        </label>
                    </div>
                    <p class="help-block hidden-md hidden-lg">
                        {{ __('dashboard.widgets.recent.help') }}
                    </p>
                </div>

                <div class="col-span-2 collapse !visible {{ isset($model) && $model->conf('singular') ? 'in' : null }}" id="widget-advanced">
                    @if($campaignService->campaign()->boosted())
                        {!! Form::hidden('config[entity-header]', 0) !!}
                        <div class="field-header checkbox">
                            <label>
                                {!! Form::checkbox('config[entity-header]', 1, (!empty($model) ? $model->conf('entity-header') : null), ['id' => 'config-entity-header']) !!}
                                {{ __('dashboard.widgets.recent.entity-header') }}

                                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.entity-header') }}" aria-hidden="true"></i>
                            </label>
                        </div>
                        <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.entity-header') }}</p>

                        @include('dashboard.widgets.forms._related')
                    @else
                        <p class="help-block">{!! __('dashboard.widgets.advanced_options_boosted', [
                    'boosted_campaign' => link_to_route('front.pricing', __('concept.boosted-campaign'), '#boost', ['target' => '_blank'])
                ]) !!}</p>
                    @endif
                </div>
                @include('dashboard.widgets.forms._name')
                @include('dashboard.widgets.forms._width')

                <div class="field-order">
                    <label>{{ __('dashboard.widgets.fields.order') }}</label>
                    {!! Form::select('config[order]', [
                '' => __('dashboard.widgets.orders.recent'),
                'name_asc' => __('dashboard.widgets.orders.name_asc'),
                'name_desc' => __('dashboard.widgets.orders.name_desc'),
            ], null, ['class' => 'form-control']) !!}
                </div>
                @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
            </x-grid>
        </div>
        <div id="advanced-{{ $mode }}" class="tab-pane fade in">
            @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')

            <x-grid>
                @include('dashboard.widgets.forms._class')
            </x-grid>
        </div>
    </div>
</div>
