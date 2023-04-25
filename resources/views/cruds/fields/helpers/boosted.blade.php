@if (auth()->check() && auth()->user()->hasBoosterNomenclature())
    @php
    $pricingOptions = [
        '#boost'
    ];
    if (isset($campaign) && $campaign instanceof \App\Models\Campaign) {
        $pricingOptions['callback'] = $campaign->id;
    } elseif (isset($campaign) && $campaign instanceof \App\Services\CampaignService) {
        $pricingOptions['callback'] = $campaignService->campaign()->id;
    }
@endphp
<div class="alert alert-info">
    {!! __($key, ['boosted-campaign' => link_to_route('front.pricing', __('concept.boosted-campaign'), $pricingOptions)]) !!}
</div>
    <?php return; ?>
@endif

    @php
    $pricingOptions = [
        '#premium'
    ];
    if (isset($campaign) && $campaign instanceof \App\Models\Campaign) {
        $pricingOptions['callback'] = $campaign->id;
    } elseif (isset($campaign) && $campaign instanceof \App\Services\CampaignService) {
        $pricingOptions['callback'] = $campaignService->campaign()->id;
    }
@endphp
<div class="alert alert-info">
    {!! __($key, ['boosted-campaign' => link_to_route('front.pricing', __('concept.premium-campaign'), $pricingOptions)]) !!}
</div>
