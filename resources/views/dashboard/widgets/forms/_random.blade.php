
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
                    {{ __('crud.fields.entity') }}
                </label>
                {!! Form::select('config[entity]', $entities, (!empty($model) ? $model->conf('entity') : null), ['class' => 'form-control']) !!}
            </div>


            <div class="row">
                <div class="col-sm-6">
                    @include('dashboard.widgets.forms._name', ['random' => true])
                </div>
                <div class="col-sm-6">
                    @include('dashboard.widgets.forms._width')
                </div>
            </div>

            <div class="form-group">
                {!! Form::tags(
                        'tag_id',
                        [
                            'model' => isset($model) ? $model : null,
                            'enableNew' => false
                        ]
                    ) !!}
                <input type="hidden" name="save_tags" value="1" />
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

                @include('dashboard.widgets.forms._related')
                @include('dashboard.widgets.forms._class')
            @endif
        </div>
    </div>
</div>
