@if (!empty(config('tracking.ga')))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('tracking.ga') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
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
    @if (!empty($tracking_new))
    <script> gtag('event', 'conversion', {'send_to': '{{ config('tracking.ga_convo') }}/pa10CJTvrssBEOaOq7oC'}); </script>
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

@if (!empty($tracking_new))
    <!-- New account confirmation -->
    <script>
        @if (!empty(config('tracking.fb')))
        fbq('track', 'CompleteRegistration', {
            value: 1,
            currency: 'USD',
        });
        @endif
        @if (!empty(config('tracking.reddit')))
        rdt('track', 'SignUp');
        @endif
    </script>
@endif
@if (!empty(config('tracking.reddit')))
    <!-- Reddit Pixel -->
    <script>
        !function(w,d){if(!w.rdt){var p=w.rdt=function(){p.sendEvent?p.sendEvent.apply(p,arguments):p.callQueue.push(arguments)};p.callQueue=[];var t=d.createElement("script");t.src="https://www.redditstatic.com/ads/pixel.js",t.async=!0;var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(t,s)}}(window,document);rdt('init','{{ config('tracking.reddit') }}');rdt('track', 'PageVisit');
    </script>
@endif

@if(!empty(config('tracking.hotjar')))
    <!-- Hotjar Tracking Code for http://kanka.io/ -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:{{ config('tracking.hotjar') }},hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
@endif

@if(!empty(config('tracking.adsense')) && (auth()->guest() || auth()->user()->showAds()) && !isset($noads))
    <script data-ad-client="{{ config('tracking.adsense') }}" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
@endif
