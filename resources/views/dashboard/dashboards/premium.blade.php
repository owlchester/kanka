<x-dialog.header>
    {{ __('concept.premium-feature') }}
</x-dialog.header>
<x-dialog.article>
    <x-helper>
        <p>{{ __('dashboard.dashboards.pitch') }}</p>
    </x-helper>
    <x-premium-cta-footer :campaign="$campaign" />
</x-dialog.article>

