@nativeAd(\App\Models\Ad::SECTION_BANNER)
<div class="ads-space overflow-hidden nativead-manager text-center" data-video="true" style="max-height: 228px;">
    {!! \App\Facades\AdCache::show() !!}
</div>
<p class="text-center text-muted">
    @php $subscribingUrl = auth()->check() ? 'settings.subscription' : 'front.pricing'; @endphp
{!! __('misc.ads.remove_v3', [
    'subscribing' => link_to_route($subscribingUrl, __('misc.ads.subscribing')),
    'boosting' => link_to_route('front.premium', __('misc.ads.premium')),
]) !!}
</p>
@else
@ads('hybrid')
<div class="ads-space overflow-hidden">
    <div class="vm-placement" id="vm-av" data-format="isvideo"></div>
    <div class="vm-placement" data-id="{{ config('tracking.venatus.hybrid') }}" data-display-type="hybrid-banner"></div>
</div>
<p class="text-center text-muted">
{!! __('misc.ads.remove_v3', [
    'subscribing' => link_to_route('settings.subscription', __('misc.ads.subscribing')),
    'boosting' => link_to_route('front.premium', __('misc.ads.premium')),
]) !!}
</p>
@endads
@endnativeAd
