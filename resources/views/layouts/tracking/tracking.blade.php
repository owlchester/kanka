@if (!empty(config('tracking.ga')))
    @php isset($campaign) ? \App\Facades\DataLayer::campaign($campaign) : null @endphp
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
    @if (isset($gaPurchase) && !empty($gaPurchase))
    <script> gtag('event', 'purchase', {
        'value': {{ $gaPurchase['value'] }},
        'currency': '{{ $gaPurchase['currency'] }}',
        'coupon': {{ $gaPurchase['coupon'] ?? 'null' }},
        'items': [{
            'item_id': '{{ $gaPurchase['item_id'] }}',
            'item_name': '{{ $gaPurchase['item_name'] }}',
            'price': {{ $gaPurchase['value'] }},
            'coupon': {{ $gaPurchase['coupon'] ?? 'null' }},
            'quantity': 1,
        }]
    }); </script>
    @endif
    <!-- End Google Analytics -->
@endif
