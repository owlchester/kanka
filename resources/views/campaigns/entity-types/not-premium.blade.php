<x-premium-cta :campaign="$campaign" premium>
    <x-slot name="title">
        <x-icon class="premium"></x-icon>
        {{ __('campaigns/modules.pitch-title') }}
    </x-slot>
    <p>{{ __('campaigns/modules.pitch-custom') }}</p>
</x-premium-cta>
