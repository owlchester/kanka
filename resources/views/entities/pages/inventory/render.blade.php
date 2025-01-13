<?php /** @var \App\Models\Entity $entity */?>
<x-tutorial code="inventory" doc="https://docs.kanka.io/en/latest/features/inventory.html">
    @if ($entity->isCharacter())
        <p>{!! __('entities/inventories.tutorials.character', ['name' => $entity->name]) !!}</p>
    @elseif ($entity->isLocation())
        <p>{!! __('entities/inventories.tutorials.location', ['name' => $entity->name]) !!}</p>
    @else
        <p>{!! __('entities/inventories.tutorials.other', ['name' => $entity->name]) !!}</p>
    @endif
</x-tutorial>
@include('entities.pages.inventory.grid')
