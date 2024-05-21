<?php /** @var \App\Models\Inventory $inventory */?>
{{ csrf_field() }}
<x-grid type="1/1">
@include('cruds.fields.entity', [
        'name' => 'entity_id',
        'required' => true,
        'label' => __('bookmarks.fields.entity'),
    ])
</x-grid>
