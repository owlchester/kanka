<?php /** @var \App\Models\Entity $entity */?>
<x-tutorial code="attributes" doc="https://docs.kanka.io/en/latest/features/attributes.html">
    <p>{!! __('entities/attributes.tutorials.general', [
        'name' => $entity->name,
    ]) !!}</p>
    @if ($entity->isCharacter())
        <p>{!! __('entities/attributes.tutorials.character', [
            'hp' => '<code>HP</code>',
            'str' => '<code>STR</code>',
        ]) !!}</p>
    @elseif ($entity->isLocation())
        <p>{!! __('entities/attributes.tutorials.location', [
            'pop' => '<code>Population</code>',
        ]) !!}</p>
    @endif
</x-tutorial>

@include('entities.pages.attributes.render')

<input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', [$campaign, $entity]) }}" />
