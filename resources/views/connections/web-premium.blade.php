<x-grid type="1/1">
    <p class="max-w-2xl">
        {!! __('connections/web.cta.text', ['amount' => '<strong>' . config('limits.campaigns.web') . '</strong>']) !!}
    </p>

    <x-premium-cta-footer :campaign="$campaign" />
</x-grid>
