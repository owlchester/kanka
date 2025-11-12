<x-ad section="siderail_right" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-sticky"></div>

    <script>
        window['nitroAds'].createAd('ad-nitro-sticky', {
            "format": "anchor-v2",
            "anchor": "bottom",
            "anchorBgColor": "rgb(0 0 0 / 80%)",
            "anchorClose": true,
            "anchorPersistClose": false,
            "anchorStickyOffset": 0,
            "report": {
                "enabled": true,
                "icon": true,
                "wording": "Report Ad",
                "position": "top-right"
            },
            "demo": {{ request()->filled('nitro_demo') ? "true" : "false" }}
        });
    </script>
</x-ad>
