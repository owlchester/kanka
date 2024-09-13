@if (!empty(config('tracking.ga')))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('tracking.ga') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({!! \App\Facades\DataLayer::base() !!});
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('tracking.ga') }}');
        gtag('consent', 'default', {
            'ad_storage': 'denied',
            'ad_user_data': 'denied',
            'ad_personalization': 'denied',
            'analytics_storage': 'denied'
        });
    @if (!empty(config('tracking.ga_convo')))
        gtag('config', '{{ config('tracking.ga_convo') }}');
    @endif
    </script>
    @if (isset($gaTrackingEvent) && !empty($gaTrackingEvent))
    <script> gtag('event', 'conversion', {'send_to': '{{ config('tracking.ga_convo') }}/{{ $gaTrackingEvent }}'}); </script>
    @endif
    <!-- End Google Analytics -->
@endif


@if (\App\Facades\AdCache::canHaveAds())
    <x-ad section="inline" :campaign="$campaign ?? null" script>
        <script id="ad-client" src="https://hb.vntsm.com/v3/live/ad-manager.min.js" type="text/javascript" data-site-id="{{ config('tracking.venatus.id') }}" data-mode="scan" async></script>
    </x-ad>
    <x-ad :campaign="$campaign ?? null"  script>
        <script data-ad-client="{{ config('tracking.adsense') }}" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" @if(!app()->isProduction())data-adtest="on"@endif></script>
    </x-ad>
@endif
