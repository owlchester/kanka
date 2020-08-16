
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('crud.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('timelines/eras.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        <div class="form-group">
            <label>{{ trans('timelines/eras.fields.abbreviation') }}</label>
            {!! Form::text('abbreviation', null, ['placeholder' => trans('timelines/eras.placeholders.abbreviation'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>


        <div class="form-group">
            <label>{{ trans('crud.fields.entry') }}</label>
            {!! Form::textarea('entry', null, ['class' => 'form-control html-editor', 'id' => 'era-entry', 'name' => 'entry']) !!}
        </div>

        <div class="form-group">
            <label>{{ trans('timelines/eras.fields.start_year') }}</label>
            {!! Form::number('start_year', null, ['placeholder' => trans('timelines/eras.placeholders.start_year'), 'class' => 'form-control', 'maxlength' => 8]) !!}
        </div>

        <div class="form-group">
            <label>{{ trans('timelines/eras.fields.end_year') }}</label>
            {!! Form::number('end_year', null, ['placeholder' => trans('timelines/eras.placeholders.end_year'), 'class' => 'form-control', 'maxlength' => 8]) !!}
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
            var editorId = 'era-entry';
            // First we remove in case it was already loaded
            tinyMCE.EditorManager.execCommand('mceFocus', false, editorId);
            tinyMCE.EditorManager.execCommand('mceRemoveEditor', true, editorId);
            // And add again
            tinymce.EditorManager.execCommand('mceAddEditor', false, editorId);
@endif
        });
    </script>
@endif
