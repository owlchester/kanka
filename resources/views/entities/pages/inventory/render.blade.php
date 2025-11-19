<?php /** @var \App\Models\Entity $entity */?>
<x-tutorial code="inventory" doc="https://docs.kanka.io/en/latest/features/inventory.html">
    <p>{!! __('entities/inventories.tutorials.all', ['name' => $entity->name]) !!}</p>
</x-tutorial>
@include('entities.pages.inventory.grid')
