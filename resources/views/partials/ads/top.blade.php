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
@ads('entity')
<div class="ads-space overflow-hidden">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="{{ config('tracking.adsense') }}"
         data-ad-slot="{{ config('tracking.adsense_entity') }}"
         data-ad-format="auto"
         @if(!app()->environment('prod'))data-adtest="on"@endif
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<p class="text-center text-muted">
{!! __('misc.ads.remove_v3', [
    'subscribing' => link_to_route('settings.subscription', __('misc.ads.subscribing')),
    'boosting' => link_to_route('front.premium', __('misc.ads.premium')),
]) !!}
</p>
@endads
@endnativeAd
