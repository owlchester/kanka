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
            'ad_storage': 'granted',
            'analytics_storage': 'granted'
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
@if (!empty(config('tracking.gtm')))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer', '{{ config('tracking.gtm') }}');</script>
    <!-- End Google Tag Manager -->
@endif
@if (!empty(config('tracking.optimize')))
    <!-- Google Optimize -->
    <script src="https://www.googleoptimize.com/optimize.js?id={{ config('tracking.optimize') }}"></script>
@endif
@if (!empty(config('tracking.fb')))
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ config('tracking.fb') }}');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id={{ config('tracking.fb') }}&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
@endif

@if (config('tracking.venatus.enabled') && request()->has('_showads'))
    <script src="https://hb.vntsm.com/v3/live/ad-manager.min.js" type="text/javascript" data-site-id="{{ config('tracking.venatus.id') }}" data-mode="scan" async></script>
@endif

@if (!empty($tracking_new))
    <!-- New account confirmation -->
    <script>
        @if (!empty(config('tracking.fb')))
        fbq('track', 'CompleteRegistration', {
            value: 1,
            currency: 'USD',
        });
        @endif
    </script>
@endif

@ads()
    @if(!isset($noads))
    <script data-ad-client="{{ config('tracking.adsense') }}" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" @if(!app()->isProduction())data-adtest="on"@endif></script>
    @endif
@endads
