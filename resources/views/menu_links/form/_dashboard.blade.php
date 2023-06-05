<?php
$dashboards = ['' => ''];
//$dashboards['default'] = __('menu_links.fields.default_dashboard');
foreach (\App\Facades\Dashboard::campaign($campaignService->campaign())->getDashboards() as $dash) {
    $dashboards[$dash->id] = $dash->name;
}
?>
<p class="help-block">
    {!! __('menu_links.helpers.dashboard') !!}
</p>

@if($campaignService->campaign()->boosted())
    <x-grid>
        <div class="form-group">
            <label>{{ __('menu_links.fields.dashboard') }}</label>
            {!! Form::select('dashboard_id', $dashboards, FormCopy::field('dashboard_id')->string(), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group checkbox">
            {!! Form::hidden('options[default_dashboard]', 0) !!}
            {{ __('menu_links.fields.default_dashboard') }}
            <label>
                {!! Form::checkbox('options[default_dashboard]', 1, empty($model->options) ? false : \Illuminate\Support\Arr::get($model->options, 'default_dashboard')) !!}
                {{ __('menu_links.helpers.default_dashboard') }}
            </label>
        </div>
    </x-grid>
@else
    <x-cta :campaign="$campaign" minimal="1" image="0">
        <p>{{ __('dashboard.dashboards.pitch') }}</p>
    </x-cta>
@endif
