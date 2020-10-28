<?php
$typeOptions = [
        0 => __('maps/layers.types.standard'),
        1 => __('maps/layers.types.overlay'),
        2 => __('maps/layers.types.overlay_shown'),
];

?>
<div class="form-group required">
    <label>{{ trans('crud.fields.name') }}</label>
    {!! Form::text('name', null, ['placeholder' => trans('maps/layers.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>

<div class="form-group">
    <label>{{ trans('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', null, ['class' => 'form-control html-editor', 'id' => 'layer-entry', 'name' => 'entry']) !!}
</div>

@include('cruds.fields.image', ['imageRequired' => true, 'size' => 'map'])

<div class="form-group">
    <label>{{ __('maps/layers.fields.type') }}</label>
    {{ Form::select('type_id', $typeOptions, null, ['class' => 'form-control', 'id' => 'type_id']) }}
</div>

<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.visibility')
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ trans('maps/layers.fields.position') }}</label>
            {!! Form::number('position', null, ['placeholder' => trans('maps/layers.placeholders.position'), 'class' => 'form-control', 'maxlength' => 3]) !!}
        </div>
    </div>
</div>

@include('editors.editor')

@if ($ajax)
    <script type="text/javascript">
        $(document).ready(function () {
            @if(auth()->user()->editor == 'summernote')
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
