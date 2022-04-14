@nativeAd('sidebar')
<div class="ads-space nativead-manager" data-video="true">
    <a href="{{ config('ads.url') }}" target="_blank" class="nativead-link">
        <video loop autoplay muted playsinline class="nativead nativead-sidebar">
            <source src="{{ config('ads.sidebar') }}"
                    type="video/webm">
        </video>
    </a>
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
