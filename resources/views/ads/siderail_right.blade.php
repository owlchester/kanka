<x-ad section="siderail_right" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-siderail-right"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-siderail-right', {
            "sizes": [
                [
                    "728",
                    "90"
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
            }
        });
    </script>
</x-ad>
