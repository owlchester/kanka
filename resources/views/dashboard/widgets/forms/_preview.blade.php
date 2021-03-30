<div class="form-group required">
    {!! Form::select2(
        'entity_id',
        !empty($model) && $model->entity ? $model->entity : null,
        App\Models\Entity::class,
        false,
        'crud.fields.entity',
        'search.entities-with-relations'
    ) !!}
</div>


{!! Form::hidden('config[full]', 0) !!}
<div class="form-group">
    <div class="checkbox">
        <label>
            {!! Form::checkbox('config[full]', 1, (!empty($model) ? $model->conf('full') : null), ['id' => 'config-full']) !!}

            {{ __('dashboard.widgets.recent.full') }}

            <i class="fa fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.full') }}"></i>
        </label>
        <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.full') }}</p>
    </div>
</div>


<div class="row">
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._name')
    </div>
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._width')
    </div>
</div>

<p class="mb-sm">
    <a href="#widget-advanced" class="mb-sm" data-toggle="collapse" data-target="#widget-advanced">{{ __('dashboard.widgets.actions.advanced-options') }}</a>
</p>
<div class="collapse {{ isset($model) && $model->hasAdvancedOptions() ? 'in' : null }}" id="widget-advanced">
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
    <p class="help-block">{{ __('dashboard.widgets.advanced_options_boosted') }}"</p>
@endif

</div>
