<x-ad section="leaderboard" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-leaderboard"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-leaderboard', {
            "delayLoading": true,
            "report": {
                "enabled": true,
                "icon": true,
                "wording": "Report Ad",
                "position": "bottom-right"
            },
            "demo": {{ request()->filled('nitro_demo') ? "true" : "false" }}
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
