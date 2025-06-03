<?php
$dashboards = ['' => ''];
//$dashboards['default'] = __('bookmarks.fields.default_dashboard');
foreach (\App\Facades\Dashboard::campaign($campaign)->getDashboards() as $dash) {
    $dashboards[$dash->id] = $dash->name;
}
?>
<x-grid type="1/1">
    <x-helper>
        <p>{{ __('bookmarks.helpers.dashboard') }}</p>
    </x-helper>

@if($campaign->boosted())
    <x-grid>
        <x-forms.field field="dashboard" :label="__('bookmarks.fields.dashboard')">
            <x-forms.select name="dashboard_id" :options="$dashboards" :selected="$source->dashboard_id ?? $model->dashboard_id ?? null" />
        </x-forms.field>

        <input type="hidden" name="options[default_dashboard]" value="0" />
        <x-forms.field field="default" :label="__('bookmarks.fields.default_dashboard')">
            <x-checkbox :text="__('bookmarks.helpers.default_dashboard')">
                <input type="checkbox" name="options[default_dashboard]" value="1" @if (old('options[default_dashboard]', empty($model->options) ? false : \Illuminate\Support\Arr::get($model->options, 'default_dashboard'))) checked="checked" @endif/>
            </x-checkbox>
        </x-forms.field>
    </x-grid>
@else
    <x-premium-cta :campaign="$campaign">
        <p>{{ __('dashboard.dashboards.pitch') }}</p>
    </x-premium-cta>
@endif
</x-grid>
