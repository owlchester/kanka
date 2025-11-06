<x-ad section="leaderboard" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-inline"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-inline', {
            "sizes": [
                [728,90]
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
</x-ad>
