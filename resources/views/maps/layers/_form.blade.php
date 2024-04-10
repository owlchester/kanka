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
        :required="true"
        :label="__('crud.fields.name')">
        {!! Form::text('name', null, ['placeholder' => __('maps/layers.placeholders.name'), 'class' => '', 'maxlength' => 191, 'required' => true]) !!}
    </x-forms.field>
    @php
        $options = $map->layerPositionOptions(!empty($model->position) ? $model->position : null);
        $last = array_key_last($options);
    @endphp
    <x-forms.field
        field="type"
        :label="__('maps/layers.fields.type')">
        {{ Form::select('type_id', $typeOptions, null, ['class' => '', 'id' => 'type_id']) }}
    </x-forms.field>

    <x-forms.field
        field="entry col-span-2"
        :label="__('crud.fields.entry')">
        {!! Form::textarea('entry', null, ['class' => ' html-editor', 'id' => 'layer-entry', 'name' => 'entry']) !!}
    </x-forms.field>

    @include('cruds.fields.visibility_id')

    <x-forms.field
        field="position"
        :label="__('maps/layers.fields.position')">
        {!! Form::select('position', $options, (!empty($model->position) ? $model->position : $last), ['class' => '']) !!}
    </x-forms.field>

    <div class="col-span-2">
    @include('cruds.fields.image', ['imageRequired' => empty($model), 'size' => 'map', 'gallery' => false, 'removable' => false])
    </div>
</x-grid>

@include('editors.editor')
