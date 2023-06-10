@php $boosted = $campaignService->campaign()->boosted() @endphp
<div class="nav-tabs-custom">
    <ul class="nav-tabs bg-base-300 !p-1 rounded" role="tablist">
        <li class="active">
            <a data-toggle="tab" href="#setup">
                {{ __('dashboard.widgets.tabs.setup') }}
            </a>
        </li>
        <li>
            <a data-toggle="tab" href="#advanced">
                {{ __('dashboard.widgets.tabs.advanced') }}
            </a>
        </li>
    </ul>

    <div class="tab-content p-4">
        <div id="setup" class="tab-pane fade in active">

            <x-grid>
                <div class="col-span-2">
                    @include('cruds.fields.entity', ['required' => true])
                </div>

                @php
                $displayOptions = [
                    0 => __('dashboard.widgets.preview.displays.expand'),
                    1 => __('dashboard.widgets.preview.displays.full'),
                    2 => __('crud.tabs.attributes'),
                ];
                @endphp
                <div class="field-display">
                    <label>{{ __('dashboard.widgets.preview.fields.display') }}</label>
                    {!! Form::select('config[full]', $displayOptions, null, ['class' => 'form-control']) !!}
                </div>

                @include('dashboard.widgets.forms._name')

                @include('dashboard.widgets.forms._width')

                @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
            </x-grid>
        </div>
        <div id="advanced" class="tab-pane fade in">
            @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')

            <x-grid>
                <div>
                    {!! Form::hidden('config[entity-header]', 0) !!}
                    <div class="field-header checkbox">
                        <label>
                            {!! Form::checkbox('config[entity-header]', 1, (!empty($model) ? $model->conf('entity-header') : null), ['id' => 'config-entity-header', 'disabled' => !$boosted ? 'disabled' : null]) !!}
                            {{ __('dashboard.widgets.recent.entity-header') }}

                            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.recent.helpers.entity-header') }}" aria-hidden="true"></i>
                        </label>
                    </div>
                <p class="help-block visible-xs visible-sm">{{ __('dashboard.widgets.recent.helpers.entity-header') }}</p>
                </div>

                @include('dashboard.widgets.forms._related')
                @include('dashboard.widgets.forms._class')
            </x-grid>
        </div>
    </div>
</div>
