<x-ad section="siderail_right" :campaign="isset($campaign) ? $campaign : null">
    <div id="yoyoyoyo"></div>
    <!-- Tag ID:  {{ config('ads.freestar.tags.siderail_right') }} -->
    <div align="center" data-freestar-ad="__200x600" id="{{ config('ads.freestar.tags.siderail_right') }}">
        <script data-cfasync="false" type="text/javascript">
            freestar.config.enabled_slots.push({ placementName: "{{ config('ads.freestar.tags.siderail_right') }}", slotId: "{{ config('ads.freestar.tags.siderail_right') }}" });
        </script>
    </div>
</x-ad>
