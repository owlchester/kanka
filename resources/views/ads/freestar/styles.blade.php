<x-ad section="incontent" script :campaign="isset($campaign) ? $campaign : null">

<link rel="preconnect" href="https://a.pub.network/" crossorigin />
<link rel="preconnect" href="https://b.pub.network/" crossorigin />
<link rel="preconnect" href="https://c.pub.network/" crossorigin />
<link rel="preconnect" href="https://d.pub.network/" crossorigin />
<link rel="preconnect" href="https://c.amazon-adsystem.com" crossorigin />
<link rel="preconnect" href="https://s.amazon-adsystem.com" crossorigin />
<link rel="preconnect" href="https://btloader.com/" crossorigin />
<link rel="preconnect" href="https://api.btloader.com/" crossorigin />
<link rel="preconnect" href="https://cdn.confiant-integrations.net" crossorigin />
<link rel="stylesheet" href="https://a.pub.network/{{ config('ads.freestar.site') }}/cls.css">

<script data-cfasync="false" type="text/javascript">
    var freestar = freestar || {};
    freestar.queue = freestar.queue || [];
    freestar.config = freestar.config || {};
    freestar.config.enabled_slots = [];
    freestar.initCallback = function () { (freestar.config.enabled_slots.length === 0) ? freestar.initCallbackCalled = false : freestar.newAdSlots(freestar.config.enabled_slots) }
</script>
<script src="https://a.pub.network/{{ config('ads.freestar.site') }}/pubfig.min.js" data-cfasync="false" async></script>
</x-ad>
