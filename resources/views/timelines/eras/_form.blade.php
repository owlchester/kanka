<x-grid>
    <x-forms.field field="name" :required="true" :label="__('crud.fields.name')">
        {!! Form::text('name', null, ['placeholder' => __('timelines/eras.placeholders.name'), 'class' => '', 'maxlength' => 191, 'required']) !!}
    </x-forms.field>

    <x-forms.field field="abbrev" :label="__('timelines/eras.fields.abbreviation')">
        {!! Form::text('abbreviation', null, ['placeholder' => __('timelines/eras.placeholders.abbreviation'), 'class' => '', 'maxlength' => 191]) !!}
    </x-forms.field>

    <x-forms.field field="entry" css="col-span-2" :label="__('crud.fields.entry')">

        <textarea name="entry"
                  id="era-entry"
                  class="html-editor"
                  rows="3"
        >{!! old('entry', $model->entryForEdition ?? null) !!}</textarea>
    </x-forms.field>

    <x-forms.field field="start" :label="__('timelines/eras.fields.start_year')">
        <input type="number" name="start_year" class="w-full" value="" maxlength="8" aria-label="{{ __('timelines/eras.placeholders.start_year') }}" placeholder="{{ __('timelines/eras.placeholders.start_year') }}" />
    </x-forms.field>

    <x-forms.field field="end" :label="__('timelines/eras.fields.end_year')">
        <input type="number" name="end_year" class="w-full" value="" maxlength="8" aria-label="{{ __('timelines/eras.placeholders.end_year') }}" placeholder="{{ __('timelines/eras.placeholders.end_year') }}" />
    </x-forms.field>

    <x-forms.field field="collapsed" css="col-span-2" :label="__('timelines/eras.fields.is_collapsed')">
        <input type="hidden" name="is_collapsed" value="0" />
        <x-checkbox :text="__('timelines/eras.helpers.is_collapsed')">
            {!! Form::checkbox('is_collapsed', 1) !!}
        </x-checkbox>
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
