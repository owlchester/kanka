<x-ad section="siderail_left" :campaign="isset($campaign) ? $campaign : null">
    <!-- Tag ID:  {{ config('ads.freestar.tags.siderail_left') }} -->
    <div align="center" data-freestar-ad="__200x600" id="{{ config('ads.freestar.tags.siderail_left') }}">
        <script data-cfasync="false" type="text/javascript">
            freestar.config.enabled_slots.push({ placementName: "{{ config('ads.freestar.tags.siderail_left') }}", slotId: "{{ config('ads.freestar.tags.siderail_left') }}" });
        </script>
    </div>
</x-ad>
