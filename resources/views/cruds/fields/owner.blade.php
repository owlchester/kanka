@php
$required = !isset($bulk);
$preset = $owner ?? null;
@endphp

@include('cruds.fields.entity', [
    'name' => 'owner_id',
    'label' => __('entities/relations.fields.owner'),
    'allowClear' => false,
    'route' => null,
])
