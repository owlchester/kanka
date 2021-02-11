<?php
$dashboards = ['' => ''];
foreach (\App\Facades\Dashboard::campaign($campaign->campaign())->getDashboards() as $dash) {
    $dashboards[$dash->id] = $dash->name;
}
?>
<p class="help-block">{!! __('menu_links.helpers.dashboard', ['boosted' => link_to_route('front.features', __('crud.boosted_campaigns'), '#boost')]) !!}</p>

@if($campaign->campaign()->boosted())
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('menu_links.fields.dashboard') }}</label>
            {!! Form::select('dashboard_id', $dashboards, FormCopy::field('dashboard_id')->string(), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
@else
    @include('partials.boosted')
@endif
