<x-ad section="siderail_right" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-sticky"></div>

    <script>
        (function () {
            var stickyOffset = 0;
            if (document.body.classList.contains('has-mobile-navigation') && window.matchMedia('(max-width: 767px)').matches) {
                var appEl = document.getElementById('app');
                var paddingBottom = appEl ? parseFloat(window.getComputedStyle(appEl).paddingBottom) : NaN;
                stickyOffset = Math.ceil(paddingBottom || 68);
            }

            window['nitroAds'].createAd('ad-nitro-sticky', {
                "format": "anchor-v2",
                "anchor": "bottom",
                "anchorBgColor": "rgb(0 0 0 / 80%)",
                "anchorClose": true,
                "anchorPersistClose": false,
                "anchorStickyOffset": stickyOffset,
                "report": {
                    "enabled": true,
                    "icon": true,
                    "wording": "Report Ad",
                    "position": "top-right"
                },
                "demo": {{ request()->filled('nitro_demo') ? "true" : "false" }}
            });
        })();
    </script>
</x-ad>
