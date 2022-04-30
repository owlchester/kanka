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

                        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.full') }}"></i>
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

            <div class="row">
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
                {!! Form::hidden('config[entity-header]', 0) !!}
                <div class="form-group checkbox">
                    <label>
                        {!! Form::checkbox('config[entity-header]', 1, (!empty($model) ? $model->conf('entity-header') : null), ['id' => 'config-entity-header']) !!}
                        {{ __('dashboard.widgets.recent.entity-header') }}

                        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.entity-header') }}"></i>
                    </label>
                </div>
                <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.entity-header') }}</p>


                @include('dashboard.widgets.forms._related')

                @include('dashboard.widgets.forms._class')
            @endif
        </div>
    </div>
</div>
