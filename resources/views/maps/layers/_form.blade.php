<?php
$typeOptions = [
        0 => __('maps/layers.types.standard'),
        1 => __('maps/layers.types.overlay'),
        2 => __('maps/layers.types.overlay_shown'),
];

?>
<x-grid>
    <x-forms.field
        field="name"
        required
        :label="__('crud.fields.name')">
        <input type="text" name="name" maxlength="191" placeholder="{{ __('maps/layers.placeholders.name') }}" required value="{!! htmlspecialchars(old('name', $model->name ?? null)) !!}" />
    </x-forms.field>
    @php
        $options = $map->layerPositionOptions(!empty($model->position) ? $model->position : null);
        $last = array_key_last($options);
    @endphp
    <x-forms.field
        field="type"
        :label="__('maps/layers.fields.type')">
        <x-forms.select name="type_id" :options="$typeOptions" :selected="$model->type_id ?? null" />
    </x-forms.field>

    <x-forms.field
        field="entry col-span-2"
        :label="__('fields.description.label')">
            @include('cruds.fields.entry', ['model' => $model])
    </x-forms.field>

    @include('cruds.fields.visibility_id')

    <x-forms.field
        field="position"
        :label="__('maps/layers.fields.position')">
        <x-forms.select name="position" :options="$options" :selected="$model->position ?? $last" />
    </x-forms.field>

    @if (!$model || empty($model->image_path))
    <div class="col-span-2">
        @include('cruds.fields.image', ['fieldname' => 'image_uuid', 'size' => 'map'])
    </div>
    @endif
</x-grid>

@include('editors.editor')
