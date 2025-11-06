<x-ad section="leaderboard" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-leaderboard"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-leaderboard', {
            "sizes": [
                [
                    "728",
                    "90"
                ],
                [
                    "970",
                    "90"
                ],
                [
                    "970",
                    "250"
                ]
            ],
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

    <div id="ad-nitro-top-mobile"></div>
    <script>
        window['nitroAds'].createAd('ad-nitro-top-mobile', {
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
                "position": "top-right"
            },
            "mediaQuery": "(max-width: 767px)"
        });
    </script>

    @php $amount = auth()->check() && auth()->user()->currency() === 'brl' ? 20 : 5; @endphp
    <p class="italic mb-4">
        {!! __('misc.ads.remove_v5', [
        'amount' => $amount,
        'currency' => auth()->check() ? auth()->user()->currencySymbol() : '$',
        'premium' =>  __('concept.premium-campaigns'),
        ]) !!}
        <a href="{{ route('settings.subscription') }}">
            {{ __('misc.ads.member') }}
        </a>
    </p>
</x-ad>
