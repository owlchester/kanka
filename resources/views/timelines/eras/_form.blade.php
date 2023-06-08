<x-grid>
    <div class="field-name required">
        <label>{{ __('crud.fields.name') }}</label>
        {!! Form::text('name', null, ['placeholder' => __('timelines/eras.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
    </div>

    <div class="field-abbrev">
        <label>{{ __('timelines/eras.fields.abbreviation') }}</label>
        {!! Form::text('abbreviation', null, ['placeholder' => __('timelines/eras.placeholders.abbreviation'), 'class' => 'form-control', 'maxlength' => 191]) !!}
    </div>

    <div class="field-entry col-span-2">
        <label>{{ __('crud.fields.entry') }}</label>
        {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'era-entry', 'name' => 'entry']) !!}
    </div>

    <div class="field-start">
        <label>{{ __('timelines/eras.fields.start_year') }}</label>
        {!! Form::number('start_year', null, ['placeholder' => __('timelines/eras.placeholders.start_year'), 'class' => 'form-control', 'maxlength' => 8]) !!}
    </div>
    <div class="field-end">
        <label>{{ __('timelines/eras.fields.end_year') }}</label>
        {!! Form::number('end_year', null, ['placeholder' => __('timelines/eras.placeholders.end_year'), 'class' => 'form-control', 'maxlength' => 8]) !!}
    </div>

    <div class="field-collapsed col-span-2 checkbox">
        <label>
            {!! Form::hidden('is_collapsed', 0) !!}
            {!! Form::checkbox('is_collapsed', 1) !!}
            {{ __('timelines/eras.fields.is_collapsed') }}
        </label>
        <p class="help-block">{{ __('timelines/eras.helpers.is_collapsed') }}</p>
    </div>
</x-grid>



@include('editors.editor', (request()->ajax() ? ['dialogsInBody' => true] : []))

@if (request()->ajax())
    <script type="text/javascript">
        $(document).ready(function () {
@if(auth()->user()->editor != 'legacy')
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
