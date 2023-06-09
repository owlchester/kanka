<?php /** @var \App\Models\Ability $model */?>
{{ csrf_field() }}

<div class="flex flex-col gap-5">
    @include('cruds.fields.entity', [
        'required' => true,
        'route' => 'search.ability-entities',
        'placeholder' => __('entities/relations.placeholders.target'),
        'preset' => false,
        'dropdownParent' => request()->ajax() ? '#entity-modal' : null,
    ])

    @include('cruds.fields.visibility_id', ['model' => null])
</div>
