@php
$advancedFilters = [
    '' => '',
    'unmentioned' => __('dashboard.widgets.recent.advanced_filters.unmentioned'),
    'mentionless' => __('dashboard.widgets.recent.advanced_filters.mentionless'),
];
@endphp
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#setup">
                {{ __('dashboard.widgets.tabs.setup') }}
            </a>
        </li>
        <li>
            <a class="" data-toggle="tab" href="#advanced">
                {{ __('dashboard.widgets.tabs.advanced') }}
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="setup" class="tab-pane fade in active">
            <div class="form-group required">
                <label for="config-entity">
                    {{ __('crud.fields.entity_type') }}
                </label>
                {!! Form::select('config[entity]', $entities, (!empty($model) ? $model->conf('entity') : null), ['class' => 'form-control recent-entity-type']) !!}
            </div>

            <div class="form-group recent-filters" style="@if (empty($model) || empty($model->conf('entity'))) display: none @else @endif">
                <label>{{ __('dashboard.widgets.recent.filters') }}</label>
                {!! Form::text('config[filters]', null, ['class' => 'form-control']) !!}
                <p class="help-block">{!! __('dashboard.widgets.recent.helpers.filters', ['link' => '<a href="' . route('helpers.widget-filters') . '" target="_blank"><i class="fas fa-external-link-alt"></i> ' . __('helpers.widget-filters.link') . '</a>']) !!}</p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    @include('dashboard.widgets.forms._tags')
                </div>
                <div class="col-md-6">
                    <label>{{ __('dashboard.widgets.recent.advanced_filter') }}</label>
                    {!! Form::select('config[adv_filter]', $advancedFilters, null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::hidden('config[singular]', 0) !!}
                <div class="checkbox" data-toggle="collapse" data-target="#widget-advanced">
                    <label>
                        {!! Form::checkbox('config[singular]', 1, (!empty($model) ? $model->conf('singular') : null)) !!}

                        {{ __('dashboard.widgets.recent.singular') }}
                        <i class="fa fa-question-circle hidden-xs hidden-sm" title="{{ __('dashboard.widgets.recent.help') }}" data-toggle="tooltip"></i>
                    </label>
                </div>
                <p class="help-block hidden-md hidden-lg">
                    {{ __('dashboard.widgets.recent.help') }}
                </p>
            </div>

            <div class="collapse {{ isset($model) && $model->conf('singular') ? 'in' : null }}" id="widget-advanced">
                @if($campaign->campaign()->boosted())
                    {!! Form::hidden('config[entity-header]', 0) !!}
                    <div class="form-group checkbox">
                        <label>
                            {!! Form::checkbox('config[entity-header]', 1, (!empty($model) ? $model->conf('entity-header') : null), ['id' => 'config-entity-header']) !!}
                            {{ __('dashboard.widgets.recent.entity-header') }}

                            <i class="fa fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.entity-header') }}"></i>
                        </label>
                    </div>
                    <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.entity-header') }}</p>


                    @include('dashboard.widgets.forms._related')

                @else
                    <p class="help-block">{!! __('dashboard.widgets.advanced_options_boosted', [
                'boosted_campaigns' => link_to_route('front.pricing', __('crud.boosted_campaigns'), '#boost', ['target' => '_blank'])
            ]) !!}"</p>
                @endif
            </div>


            <div class="row">
                <div class="col-sm-6">
                    @include('dashboard.widgets.forms._name')
                </div>
                <div class="col-sm-6">
                    @include('dashboard.widgets.forms._width')
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.widgets.fields.order') }}</label>
                        {!! Form::select('config[order]', [
                    '' => __('dashboard.widgets.orders.recent'),
                    'name_asc' => __('dashboard.widgets.orders.name_asc'),
                    'name_desc' => __('dashboard.widgets.orders.name_desc'),
                ], null, ['class' => 'form-control']) !!}
                    </div>

                </div>
            @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
            </div>
        </div>
        <div id="advanced" class="tab-pane fade in">
            @if(!$campaign->campaign()->boosted())
                <p class="help-block">
                    {!! __('dashboard.widgets.advanced_options_boosted', [
                        'boosted_campaigns' => link_to_route('front.pricing', __('crud.boosted_campaigns'), '#boost', ['target' => '_blank'])
                    ]) !!}
                </p>
            @else
                @include('dashboard.widgets.forms._class')
            @endif
        </div>
    </div>
</div>
