@if (!empty(config('tracking.ga')))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('tracking.ga') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({!! \App\Facades\DataLayer::campaign($campaign ?? null)->base() !!});
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

@endif
