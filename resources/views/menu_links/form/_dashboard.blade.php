<?php
$dashboards = ['' => ''];
foreach (\App\Facades\Dashboard::campaign($campaign->campaign())->getDashboards() as $dash) {
    $dashboards[$dash->id] = $dash->name;
}
?>
<p class="help-block">{!! __('menu_links.helpers.dashboard', []) !!}</p>

<div class="form-group">
    <label>{{ __('menu_links.fields.dashboard') }}</label>
    {!! Form::select('dashboard_id', $dashboards, FormCopy::field('dashboard_id')->string(), ['class' => 'form-control']) !!}
</div>

