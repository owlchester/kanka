<?php
$typeOptions = [
        0 => __('maps/layers.types.standard'),
        1 => __('maps/layers.types.overlay'),
        2 => __('maps/layers.types.overlay_shown'),
];

?>
<x-grid>
    <div class="field-name required name">
        <label>{{ __('crud.fields.name') }}</label>
        {!! Form::text('name', null, ['placeholder' => __('maps/layers.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191, 'required' => true]) !!}
    </div>
    @php
        $options = $map->layerPositionOptions(!empty($model->position) ? $model->position : null);
        $last = array_key_last($options);
    @endphp
    <div class="field-type">
        <label>{{ __('maps/layers.fields.type') }}</label>
        {{ Form::select('type_id', $typeOptions, null, ['class' => 'form-control', 'id' => 'type_id']) }}
    </div>

    <div class="field-entry col-span-2">
        <label>{{ __('crud.fields.entry') }}</label>
        {!! Form::textarea('entry', null, ['class' => 'form-control html-editor', 'id' => 'layer-entry', 'name' => 'entry']) !!}
    </div>

    @include('cruds.fields.visibility_id')

    <div class="field-position">
        <label>{{ __('maps/layers.fields.position') }}</label>
        {!! Form::select('position', $options, (!empty($model->position) ? $model->position : $last), ['class' => 'form-control']) !!}
    </div>

    @include('cruds.fields.image', ['imageRequired' => true, 'size' => 'map'])
</x-grid>

@include('editors.editor')
