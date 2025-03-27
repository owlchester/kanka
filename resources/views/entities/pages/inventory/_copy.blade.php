<?php /** @var \App\Models\Inventory $inventory */?>
<x-grid type="1/1">
    <x-helper>{{ __('entities/inventories.copy.helper', ['name' => $entity->name]) }}</x-helper>
    @include('cruds.fields.entity', [
        'name' => 'entity_id',
        'required' => true,
        'label' => __('entities.entity'),
    ])
</x-grid>
