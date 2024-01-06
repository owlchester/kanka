@inject('entityService', 'App\Services\EntityService')
@php
    $advancedFilters = [
        '' => '',
        'unmentioned' => __('dashboard.widgets.recent.advanced_filters.unmentioned'),
        'mentionless' => __('dashboard.widgets.recent.advanced_filters.mentionless'),
    ];
    $boosted = $campaign->boosted();
    $entityTypes = ['' => 'All'];
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
                <x-forms.field field="entity-type" :required="true" :label="__('crud.fields.entity_type')">
                    {!! Form::select('config[entity]', $entityTypes, (!empty($model) ? $model->conf('entity') : null), ['class' => ' recent-entity-type', 'data-animate' => 'reveal', 'data-target' => '.field-recent-filters']) !!}
                </x-forms.field>

                <x-forms.field
                    field="recent-filters"
                    :label="__('dashboard.widgets.recent.filters')"
                    link="https://docs.kanka.io/en/latest/guides/dashboard.html"
                    :tooltip="true"
                    :helper="__('dashboard.widgets.helpers.filters')"
                    :hidden="empty($model) || empty($model->conf('entity'))">
                    {!! Form::text('config[filters]', null, ['class' => '', 'maxlength' => 191]) !!}
                </x-forms.field>

                @include('dashboard.widgets.forms._tags')

                <x-forms.field field="advanced-filters" :label="__('dashboard.widgets.recent.advanced_filter')">
                    {!! Form::select('config[adv_filter]', $advancedFilters, null, ['class' => '']) !!}
                </x-forms.field>

                <x-forms.field field="singular" css="col-span-2" :label="__('dashboard.widgets.recent.singular')">
                    {!! Form::hidden('config[singular]', 0) !!}
                    <div class="checkbox" data-animate="collapse" data-target="#widget-advanced">
                        <x-checkbox :text="__('dashboard.widgets.recent.help')">
                            {!! Form::checkbox('config[singular]', 1, (!empty($model) ? $model->conf('singular') : null)) !!}
                        </x-checkbox>
                    </div>
                </x-forms.field>

                <div class="col-span-2 hidden {{ isset($model) && $model->conf('singular') ? 'in' : null }}" id="widget-advanced">
                    @if($campaign->boosted())
                        @include('dashboard.widgets.forms._header_select')
                        @include('dashboard.widgets.forms._related')
                    @else
                        <x-helper>
                            {!! __('dashboard.widgets.advanced_options_boosted', [
                    'boosted_campaign' => link_to('https://' . config('domains.front') . '/pricing', __('concept.boosted-campaign'), '#boost', ['target' => '_blank'])]) !!}
                        </x-helper>
                    @endif
                </div>
                @include('dashboard.widgets.forms._name')
                @include('dashboard.widgets.forms._width')

                <x-forms.field field="orger" :label="__('dashboard.widgets.fields.order')">
                    {!! Form::select('config[order]', [
                '' => __('dashboard.widgets.orders.recent'),
                'oldest' => __('dashboard.widgets.orders.oldest'),
                'name_asc' => __('dashboard.widgets.orders.name_asc'),
                'name_desc' => __('dashboard.widgets.orders.name_desc'),
            ], null, ['class' => '']) !!}
                </x-forms.field>
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
