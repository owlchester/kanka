@nativeAd(\App\Models\Ad::SECTION_BANNER)
<div class="ads-space nativead-manager" data-video="true" style="max-height: 228px;">
    {!! \App\Facades\AdCache::show() !!}
</div>
<p class="text-center text-muted">
    {!! __('misc.ads.remove_v2', [
'supporting' => link_to_route('settings.subscription', __('misc.ads.supporting'), [], ['target' => '_blank']),
'boosting' => link_to_route('front.pricing', __('misc.ads.boosting'), ['#boost'], ['target' => '_blank']),
]) !!}
</p>
@else
@ads('entity')
<div class="ads-space">
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
    {!! __('misc.ads.remove_v2', [
'supporting' => link_to_route('settings.subscription', __('misc.ads.supporting'), [], ['target' => '_blank']),
'boosting' => link_to_route('front.pricing', __('misc.ads.boosting'), ['#boost'], ['target' => '_blank']),
]) !!}
</p>
@endads
@endnativeAd
