<x-alert type="info">
    <p>
        @if (auth()->check() && auth()->user()->hasBoosterNomenclature())
            {!! __($key, ['boosted-campaign' => '<a href="https://kanka.io/premium">' . __('concept.superboosted-campaign') . '</a>']) !!}
        @else
            {!! __($key, ['boosted-campaign' => '<a href="https://kanka.io/premium">' . __('concept.premium-campaign') . '</a>']) !!}
        @endif
    </p>
</x-alert>
