<?php /** @var \App\Models\Entity $entity */?>
<x-tutorial code="attributes" doc="https://docs.kanka.io/en/latest/features/abilities.html">
    <x-slot name="title">
        {{ __('onboarding/attributes.title') }}
    </x-slot>
    <p>{!! __('onboarding/attributes.text', [
        'name' => $entity->name,
    ]) !!}</p>

</x-tutorial>

@include('entities.pages.attributes.render')

<input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', [$campaign, $entity]) }}" />
