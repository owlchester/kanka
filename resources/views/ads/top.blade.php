<x-ad section="leaderboard" :campaign="isset($campaign) ? $campaign : null">
    <!-- Tag ID:  {{ \App\Facades\AdCache::newId()->id(config('ads.freestar.tags.leaderboard')) }} -->
    <div align="center" data-freestar-ad="__200x600" id="{{ \App\Facades\AdCache::id(config('ads.freestar.tags.leaderboard')) }}">
        <script data-cfasync="false" type="text/javascript">
            freestar.config.enabled_slots.push({ placementName: "{{ config('ads.freestar.tags.leaderboard') }}", slotId: "{{ \App\Facades\AdCache::id(config('ads.freestar.tags.leaderboard')) }}" });
        </script>
    </div>
    @php $amount = auth()->check() && auth()->user()->currency() === 'brl' ? 20 : 5; @endphp
    <p class="italic mb-4">
        {!! __('misc.ads.remove_v5', [
        'amount' => $amount,
        'currency' => auth()->check() ? auth()->user()->currencySymbol() : '$',
        'premium' =>  __('concept.premium-campaigns'),
        ]) !!}
        <a href="{{ route('settings.subscription') }}">
            {{ __('misc.ads.member') }}
        </a>
    </p>
</x-ad>
