@nativeAd('sidebar')
<div class="ads-space nativead-manager" data-video="true">
    @if (config('ads.provider') === 'dScryb')
    <a href="{{ config('ads.dScryb.url') }}" target="_blank" class="nativead-link">
        <video loop autoplay muted playsinline class="nativead nativead-sidebar" @if (config('ads.dScryb.posters.sidebar')) poster="{{ config('ads.dScryb.posters.sidebar') }}" @endif>
            <source src="{{ config('ads.dScryb.sidebar') }}"
                    type="video/webm">
        </video>
    </a>
    @else
    <a href="{{ config('ads.ks.url') }}" target="_blank" class="nativead-link" style="width:280px; height:280px">
        <img src="{{ config('ads.ks.sidebar') }}" class="nativead nativead-sidebar" />
    </a>
    @endif
</div>
@else
    @ads('sidebar')
    <div class="ads-space">
        <ins class="adsbygoogle"
             style="display:inline-block;width:280px;height:280px"
             data-ad-client="{{ config('tracking.adsense') }}"
             data-ad-slot="{{ config('tracking.adsense_sidebar') }}"
             @if(!app()->environment('prod'))data-adtest="on"@endif
        ></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    @endads
    @endnativeAd
