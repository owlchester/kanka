<x-ad section="incontent" :campaign="isset($campaign) ? $campaign : null">
    <!-- Tag ID: {{ config('ads.freestar.tags.incontent') }} -->
    <div align="center" data-freestar-ad="__300x400 __336x280" id="{{ config('ads.freestar.tags.incontent') }}">
        <script data-cfasync="false" type="text/javascript">
            freestar.config.enabled_slots.push({ placementName: "{{ config('ads.freestar.tags.incontent') }}", slotId: "{{ config('ads.freestar.tags.incontent') }}" });
        </script>
    </div>
</x-ad>
