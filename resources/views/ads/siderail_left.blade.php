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
            }
        });
    </script>
</x-ad>
