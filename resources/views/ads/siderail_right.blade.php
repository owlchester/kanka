<x-ad section="siderail_right" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-siderail-right"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-siderail-right', {
            "sizes": [
                [
                    "160",
                    "600"
                ],
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


    <div id="ad-nitro-siderail-right-mobile"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-siderail-right-mobile', {
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
            "mediaQuery": "(max-width: 767px)",
            "demo": {{ request()->filled('nitro_demo') ? "true" : "false" }}
        });
    </script>
</x-ad>
