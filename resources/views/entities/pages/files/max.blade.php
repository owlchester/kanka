<x-dialog.header>
    {{ __('entities/files.max.title') }}
</x-dialog.header>
<article>
    @if ($campaign->superboosted())
        <p>{{ __('entities/files.call-to-action.error') }}</p>
    @else
    <x-cta :campaign="$campaign" image="0" :max="$campaign->superboosted()" :cta="__('entities/files.call-to-action.premium')">
        <p>{{ __('entities/files.call-to-action.error') }}</p>
    </x-cta>
    @endif
</article>
