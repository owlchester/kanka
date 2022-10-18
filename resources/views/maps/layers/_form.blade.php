<?php
$typeOptions = [
        0 => __('maps/layers.types.standard'),
        1 => __('maps/layers.types.overlay'),
        2 => __('maps/layers.types.overlay_shown'),
];

?>
<div class="form-group required">
    <label>{{ __('crud.fields.name') }}</label>
    {!! Form::text('name', null, ['placeholder' => __('maps/layers.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191, 'required' => true]) !!}
</div>

<div class="form-group">
    <label>{{ __('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', null, ['class' => 'form-control html-editor', 'id' => 'layer-entry', 'name' => 'entry']) !!}
</div>

@include('cruds.fields.image', ['imageRequired' => true, 'size' => 'map'])

<div class="form-group">
    <label>{{ __('maps/layers.fields.type') }}</label>
    {{ Form::select('type_id', $typeOptions, null, ['class' => 'form-control', 'id' => 'type_id']) }}
</div>

@php 
    $options = $map->layerPositionOptions();
    $last = array_key_last($options);
@endphp

<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.visibility_id')
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ __('maps/layers.fields.position') }}</label>
            {!! Form::select('position', $options, (!empty($layer) ? $layer : $last), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

@include('editors.editor')

@if ($ajax)
    <script type="text/javascript">
        $(document).ready(function () {
            @if(auth()->user()->editor != 'legacy')
                window.initSummernote();
            @else
                var editorId = 'layer-entry';
                // First we remove in case it was already loaded
                tinyMCE.EditorManager.execCommand('mceFocus', false, editorId);
                tinyMCE.EditorManager.execCommand('mceRemoveEditor', true, editorId);
                // And add again
                tinymce.EditorManager.execCommand('mceAddEditor', false, editorId);
            @endif
        });
    </script>
@endif
