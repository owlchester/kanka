<x-ad section="video" :campaign="isset($campaign) ? $campaign : null">
    <div id="ad-nitro-video" class="mx-auto"></div>
    <script>
        window['nitroAds'].createAd('ad-nitro-video', {
            "format": "floating",
            "demo": {{ request()->filled('nitro_demo') ? "true" : "false" }}
        });
    </script>

</x-ad>
