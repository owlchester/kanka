@nativeAd(\App\Models\Ad::SECTION_SIDEBAR)
<div class="ads-space nativead-manager" data-video="true">
    {!! \App\Facades\AdCache::show() !!}
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
