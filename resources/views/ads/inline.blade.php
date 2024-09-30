<x-ad section="leaderboard" :campaign="isset($campaign) ? $campaign : null">
    <!-- Tag ID:  {{ \App\Facades\AdCache::newId()->id(config('ads.freestar.tags.leaderboard')) }} -->
    <div align="center" data-freestar-ad="__200x600" id="{{ \App\Facades\AdCache::id(config('ads.freestar.tags.leaderboard')) }}">
        <script data-cfasync="false" type="text/javascript">
            freestar.config.enabled_slots.push({ placementName: "{{ config('ads.freestar.tags.leaderboard') }}", slotId: "{{ \App\Facades\AdCache::id(config('ads.freestar.tags.leaderboard')) }}" });
        </script>
    </div>
</x-ad>
