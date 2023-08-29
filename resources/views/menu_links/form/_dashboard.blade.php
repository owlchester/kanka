<?php
$dashboards = ['' => ''];
//$dashboards['default'] = __('menu_links.fields.default_dashboard');
foreach (\App\Facades\Dashboard::campaign($campaign)->getDashboards() as $dash) {
    $dashboards[$dash->id] = $dash->name;
}
?>
<p class="help-block">
    {!! __('menu_links.helpers.dashboard') !!}
</p>

@if($campaign->boosted())
    <x-grid>
        <x-forms.field field="dashboard" :label="__('menu_links.fields.dashboard')">
            {!! Form::select('dashboard_id', $dashboards, FormCopy::field('dashboard_id')->string(), ['class' => 'form-control']) !!}
        </x-forms.field>

        {!! Form::hidden('options[default_dashboard]', 0) !!}
        <x-forms.field field="default" :label="__('menu_links.fields.default_dashboard')">
            <label class="text-neutral-content cursor-pointer flex gap-2">
                {!! Form::checkbox('options[default_dashboard]', 1, empty($model->options) ? false : \Illuminate\Support\Arr::get($model->options, 'default_dashboard')) !!}
                {{ __('menu_links.helpers.default_dashboard') }}
            </label>
        </x-forms.field>
    </x-grid>
@else
    <x-cta :campaign="$campaign" minimal="1" image="0">
        <p>{{ __('dashboard.dashboards.pitch') }}</p>
    </x-cta>
@endif
