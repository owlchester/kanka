@php
$pricingOptions = [
    '#boost'
];
if (isset($campaign) && $campaign instanceof \App\Models\Campaign) {
    $pricingOptions['callback'] = $campaign->id;
} elseif (isset($campaign) && $campaign instanceof \App\Services\CampaignService) {
    $pricingOptions['callback'] = $campaign->campaign()->id;
}
@endphp
@if(isset($callout) && $callout)
    <div class="callout callout-info">
        <h4><i class="fa-solid fa-rocket"></i> {{ __('crud.errors.unavailable_feature') }}</h4>
        <p>
            {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('front.pricing', __('crud.boosted_campaigns'), $pricingOptions)]) !!}
        </p>
    </div>
@else
    <p class="help-block">
        {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('front.pricing', __('crud.boosted_campaigns'), $pricingOptions)]) !!}
    </p>
@endif
