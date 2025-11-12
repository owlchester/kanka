<x-ad section="siderail_left" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-siderail-left"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-siderail-left', {
            "sizes": [
                [
                    "160",
                    "600"
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

    <div id="ad-nitro-siderail-left-mobile"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-siderail-left-mobile', {
            "sizes": [
                [
                    "320",
                    "100"
                ],
                [
                    "320",
                    "50"
                ],
                [
                    "300",
                    "250"
                ],
                [
                    "320",
                    "480"
                ],
                [
                    "336",
                    "280"
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
