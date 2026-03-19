<x-dialog.header>
    {{ $title ?? __('concept.premium-feature') }}
</x-dialog.header>
<x-dialog.article class="max-w-xl">
    <x-grid type="1/1">
        <p>
            {{ __('settings/premium.create.pitch_2026') }}
        </p>
    </x-grid>
</x-dialog.article>
<x-premium-cta-footer :campaign="$campaign" />
