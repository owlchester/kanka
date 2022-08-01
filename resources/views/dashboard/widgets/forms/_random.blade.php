@php $boosted = $campaignService->campaign()->boosted() @endphp

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

            <div class="row">
                <div class="col-sm-6">

                    <div class="form-group required">
                        <label for="config-entity">
                            {{ __('menu_links.fields.random_type') }}
                        </label>
                        {!! Form::select('config[entity]', $entities, (!empty($model) ? $model->conf('entity') : null), ['class' => 'form-control recent-entity-type']) !!}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group recent-filters" style="@if (empty($model) || empty($model->conf('entity'))) display: none @else @endif">
                        <label>
                            {{ __('dashboard.widgets.recent.filters') }}
                            <a href="//docs.kanka.io/en/latest/guides/dashboard.html" target="_blank">
                                <i class="fa-solid fa-question-circle" title="{{ __('dashboard.widgets.helpers.filters') }}" data-toggle="tooltip"></i>
                            </a>
                        </label>
                        {!! Form::text('config[filters]', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    @include('dashboard.widgets.forms._name', ['random' => true])
                </div>
                <div class="col-sm-6">
                    @include('dashboard.widgets.forms._width')
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::tags(
                                'tag_id',
                                [
                                    'model' => isset($model) ? $model : null,
                                    'enableNew' => false,
                                    'enableAutoTags' => false,
                                ]
                            ) !!}
                        <input type="hidden" name="save_tags" value="1" />
                    </div>
                </div>
            </div>


            <div class="row">
                @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
            </div>
        </div>

        <div id="advanced" class="tab-pane fade in">
            @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')

            <div class="grid grid-cols-2 gap-2">
                @include('dashboard.widgets.forms._related')
                @include('dashboard.widgets.forms._class')
            </div>
        </div>
    </div>
</div>
