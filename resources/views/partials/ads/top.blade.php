@nativeAd('banner')
<div class="ads-space nativead-manager" data-video="true" style="max-height: 228px;">
    @if (config('ads.provider') === 'dScryb')
    <a href="{{ config('ads.dScryb.url') }}" target="_blank" class="nativead-link">
        <video loop autoplay muted playsinline class="nativead nativead-banner" style="max-width: 920px;" @if (config('ads.dScryb.posters.banner')) poster="{{ config('ads.dScryb.posters.banner') }}" @endif>
            <source src="{{ config('ads.dScryb.banner') }}"
                    type="video/webm">
        </video>
    </a>
    @else
        <a href="{{ config('ads.ks.url') }}" target="_blank" class="nativead-link" style="max-width:900px; max-height:225px">
            <img src="{{ config('ads.ks.banner') }}" class="nativead nativead-banner" />
        </a>
    @endif
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
