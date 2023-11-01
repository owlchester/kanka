<?php /** @var \App\Models\Ability $model */?>
{{ csrf_field() }}

<x-grid type="1/1">
    @include('cruds.fields.entity', [
        'required' => true,
        'route' => 'search.ability-entities',
        'placeholder' => __('entities/relations.placeholders.target'),
        'preset' => false,
        'dropdownParent' => request()->ajax() ? '#primary-dialog' : null,
    ])

    @include('cruds.fields.visibility_id', ['model' => null])
</x-grid>
