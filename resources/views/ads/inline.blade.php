<x-ad section="leaderboard" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-inline"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-inline', {
            "delayLoading": true,
            "report": {
                "enabled": true,
                "icon": true,
                "wording": "Report Ad",
                "position": "bottom-right"
            },
            "mediaQuery": "(min-width: 1025px)",
            "demo": {{ request()->filled('nitro_demo') ? "true" : "false" }}
        });
    </script>

    <div id="ad-nitro-inline-mobile"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-inline-mobile', {
            "sizes": [
                [
                    "320",
                    "50"
                ],
                [
                    "320",
                    "100"
                ]
            ],
            "report": {
                "enabled": true,
                "icon": true,
                "wording": "Report Ad",
                "position": "bottom-right"
            },
            "mediaQuery": "(max-width: 767px)",
            "demo": {{ request()->filled('nitro_demo') ? "true" : "false" }}
        });
    </script>

    @isset($cta)
        @php $amount = auth()->check() && auth()->user()->currency() === 'brl' ? 20 : 5; @endphp
        <p class="italic mb-4 mx-4">
            {!! __('misc.ads.remove_v5', [
            'amount' => $amount,
            'currency' => auth()->check() ? auth()->user()->currencySymbol() : '$',
            'premium' =>  __('concept.premium-campaigns'),
            ]) !!}
            <a href="{{ route('settings.subscription') }}">
                {{ __('misc.ads.member') }}
            </a>
        </p>
    @endif
</x-ad>
