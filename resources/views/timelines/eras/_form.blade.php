<x-grid>
    <x-forms.field field="name" :required="true" :label="__('crud.fields.name')">
        {!! Form::text('name', null, ['placeholder' => __('timelines/eras.placeholders.name'), 'class' => '', 'maxlength' => 191, 'required']) !!}
    </x-forms.field>

    <x-forms.field field="abbrev" :label="__('timelines/eras.fields.abbreviation')">
        {!! Form::text('abbreviation', null, ['placeholder' => __('timelines/eras.placeholders.abbreviation'), 'class' => '', 'maxlength' => 191]) !!}
    </x-forms.field>

    <x-forms.field field="entry" css="col-span-2" :label="__('crud.fields.entry')">
        {!! Form::textarea('entryForEdition', null, ['class' => ' html-editor', 'id' => 'era-entry', 'name' => 'entry']) !!}
    </x-forms.field>

    <x-forms.field field="start" :label="__('timelines/eras.fields.start_year')">
        {!! Form::number('start_year', null, ['placeholder' => __('timelines/eras.placeholders.start_year'), 'class' => '', 'maxlength' => 8]) !!}
    </x-forms.field>

    <x-forms.field field="end" :label="__('timelines/eras.fields.end_year')">
        {!! Form::number('end_year', null, ['placeholder' => __('timelines/eras.placeholders.end_year'), 'class' => '', 'maxlength' => 8]) !!}
    </x-forms.field>

    <x-forms.field field="collapsed" css="col-span-2" :label="__('timelines/eras.fields.is_collapsed')">
        {!! Form::hidden('is_collapsed', 0) !!}
        <label class="text-neutral-content cursor-pointer flex gap-2">
            {!! Form::checkbox('is_collapsed', 1) !!}
            <span>{{ __('timelines/eras.helpers.is_collapsed') }}</span>
        </label>
    </x-forms.field>
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
