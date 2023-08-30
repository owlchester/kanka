<?php /** @var \App\Models\Tag $model */?>
{{ csrf_field() }}
<x-grid type="1/1">
@include('cruds.fields.entity', [
    'placeholder' => __('entities/relations.placeholders.target'),
    'preset' => false,
    'route' => 'search.tag-children',
    'dropdownParent' => request()->ajax() ? '#primary-dialog' : null
])
</x-grid>


