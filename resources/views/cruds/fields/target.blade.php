@php
$required = !isset($bulk);
$preset = $target ?? null;
@endphp
@if(empty($relation) && $required)
    <x-forms.foreign
        field="targets"
        required
        label="entities/relations.fields.targets"
        :multiple="true"
        name="targets[]"
        id="targets[]"
        :campaign="$campaign"
        :placeholder="__('crud.placeholders.multiple')"
        :route="route('search.entities-with-relations', [$campaign])"
    >
    </x-forms.foreign>
@else
    @include('cruds.fields.entity', [
        'name' => 'target_id',
        'label' => __('entities/relations.fields.targets'),
        'placeholder' => __('crud.placeholders.multiple'),
        'allowClear' => false,
        'route' => null,
    ])
@endif
