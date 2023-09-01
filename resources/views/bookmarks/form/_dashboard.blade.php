<?php
$dashboards = ['' => ''];
//$dashboards['default'] = __('menu_links.fields.default_dashboard');
foreach (\App\Facades\Dashboard::campaign($campaign)->getDashboards() as $dash) {
    $dashboards[$dash->id] = $dash->name;
}
?>
<x-grid type="1/1">
    <x-helper :text="__('menu_links.helpers.dashboard')" />

@if($campaign->boosted())
    <x-grid>
        <x-forms.field field="dashboard" :label="__('menu_links.fields.dashboard')">
            {!! Form::select('dashboard_id', $dashboards, FormCopy::field('dashboard_id')->string(), ['class' => '']) !!}
        </x-forms.field>

        {!! Form::hidden('options[default_dashboard]', 0) !!}
        <x-forms.field field="default" :label="__('menu_links.fields.default_dashboard')">
            <x-checkbox :text="__('menu_links.helpers.default_dashboard')">
                {!! Form::checkbox('options[default_dashboard]', 1, empty($model->options) ? false : \Illuminate\Support\Arr::get($model->options, 'default_dashboard')) !!}
            </x-checkbox>
        </x-forms.field>
    </x-grid>
@else
    <x-cta :campaign="$campaign" minimal="1" image="0">
        <p>{{ __('dashboard.dashboards.pitch') }}</p>
    </x-cta>
@endif
</x-grid>
