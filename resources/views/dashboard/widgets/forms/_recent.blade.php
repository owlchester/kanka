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

@include('dashboard.widgets.forms._tags')

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

<div class="collapse {{ isset($model) && ($model->hasAdvancedOptions() || $model->conf('singular')) ? 'in' : null }}" id="widget-advanced">
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


        <div class="row">
            <div class="col-sm-6">
                {!! Form::hidden('config[attributes]', 0) !!}
                <div class="form-group checkbox">
                    <label>
                        {!! Form::checkbox('config[attributes]', 1, (!empty($model) ? $model->conf('attributes') : null), ['id' => 'config-attributes']) !!}
                        {{ __('dashboard.widgets.recent.show_attributes') }}
                        <i class="fa fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.show_attributes') }}"></i>
                    </label>
                </div>
                <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.show_attributes') }}</p>
            </div>

            <div class="col-sm-6">
                {!! Form::hidden('config[members]', 0) !!}
                <div class="form-group checkbox">
                    <label>
                        {!! Form::checkbox('config[members]', 1, (!empty($model) ? $model->conf('members') : null), ['id' => 'config-members']) !!}
                        {{ __('dashboard.widgets.recent.show_members') }}
                        <i class="fa fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.show_members') }}"></i>
                    </label>
                </div>
                <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.show_members') }}</p>
            </div>
        </div>
    @else
        <p class="help-block">{!! __('dashboard.widgets.advanced_options_boosted', [
    'boosted_campaigns' => link_to_route('front.features', __('crud.boosted_campaigns'), '#boost', ['target' => '_blank'])
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
