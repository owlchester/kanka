<x-premium-cta :campaign="$campaign" premium>
    <x-slot name="title">
        <x-icon class="premium"></x-icon>
        {{ __('post_layouts.pitch.title') }}
    </x-slot>
    <p>{!! __('post_layouts.pitch.custom', ['entity' => $entity->name]) !!}</p>
</x-premium-cta>
