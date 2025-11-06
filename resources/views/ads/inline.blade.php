<x-ad section="leaderboard" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-inline"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-inline', {
            "sizes": [
                [
                    "728",
                    "90"
                ]
            ],
            "report": {
                "enabled": true,
                "icon": true,
                "wording": "Report Ad",
                "position": "bottom-right"
            }
        });
    </script>
</x-ad>
