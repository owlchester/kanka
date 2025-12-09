<x-alert type="info">
    <p>
        @can('boost', auth()->user())
            {!! __($key, ['boosted-campaign' => '<a href="https://kanka.io/premium" class="text-link">' . __('concept.superboosted-campaign') . '</a>']) !!}
        @else
            {!! __($key, ['boosted-campaign' => '<a href="https://kanka.io/premium" class="text-link">' . __('concept.premium-campaign') . '</a>']) !!}
        @endif
    </p>
</x-alert>
