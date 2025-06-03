<x-dialog.header>
    {{ __('concept.premium-feature') }}
</x-dialog.header>
<x-dialog.article class="max-w-3xl">
    <x-helper>
        <p>{{ __('entities/links.call-to-action') }}</p>
    </x-helper>
    <x-premium-cta-footer :campaign="$campaign" />
</x-dialog.article>

