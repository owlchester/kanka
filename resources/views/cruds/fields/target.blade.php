@php
$required = !isset($bulk);
$preset = $target ?? null;
@endphp
@if(empty($relation) && $required)
    <x-forms.foreign
        field="targets"
        required
        label="entities/relations.fields.target"
        :multiple="true"
        name="targets[]"
        id="targets[]"
        :campaign="$campaign"
        :route="route('search.entities-with-relations', [$campaign])"
    >
    </x-forms.foreign>
@else
    @include('cruds.fields.entity', [
        'name' => 'target_id',
        'label' => __('entities/relations.fields.target'),
        'allowClear' => false,
        'route' => null,
    ])
@endif
