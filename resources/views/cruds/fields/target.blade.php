@php
$required = !isset($bulk);
$preset = $target ?? null;
@endphp

@include('cruds.fields.entity', [
    'name' => 'target_id',
    'label' => __('entities/relations.fields.target'),
    'allowClear' => false,
    'route' => null,
])
