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
            "demo": {{ request()->filled('nitro_demo') ? "true" : "false" }}
        });
    </script>
</x-ad>
