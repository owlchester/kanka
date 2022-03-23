@ads('entity')
<div class="ads-space">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="{{ config('tracking.adsense') }}"
         data-ad-slot="{{ config('tracking.adsense_entity') }}"
         data-ad-format="auto"
         @if(!app()->environment('prod'))data-adtest="on"@endif
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
@endads
