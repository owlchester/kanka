<x-grid>
    <x-forms.field field="name" required :label="__('crud.fields.name')">
        <input type="text" name="name"  placeholder="{{ __('timelines/eras.placeholders.name') }}" value="{!! htmlspecialchars(old('name', $model->name ?? null)) !!}" maxlength="191" required />
    </x-forms.field>

    <x-forms.field field="abbrev" :label="__('timelines/eras.fields.abbreviation')">
        <input type="text" name="abbreviation" value="{{ old('abbreviation', $source->abbreviation ?? $model->abbreviation ?? null) }}" placeholder="{{ __('timelines/eras.placeholders.abbreviation') }}" class="w-full" maxlength="191" />
    </x-forms.field>

    <x-forms.field field="entry" css="col-span-2" :label="__('crud.fields.entry')">

        <textarea name="entry"
                  id="era-entry"
                  class="html-editor"
                  rows="3"
        >{!! old('entry', $model->entryForEdition ?? null) !!}</textarea>
    </x-forms.field>

    <x-forms.field field="start" :label="__('timelines/eras.fields.start_year')">
        <input type="number" name="start_year" class="w-full" maxlength="8" aria-label="{{ __('timelines/eras.placeholders.start_year') }}" placeholder="{{ __('timelines/eras.placeholders.start_year') }}" value="{{ old('start_year', $source->start_year ?? $model->start_year ?? null) }}" />
    </x-forms.field>

    <x-forms.field field="end" :label="__('timelines/eras.fields.end_year')">
        <input type="number" name="end_year" class="w-full" maxlength="8" aria-label="{{ __('timelines/eras.placeholders.end_year') }}" placeholder="{{ __('timelines/eras.placeholders.end_year') }}" value="{{ old('end_year', $source->end_year ?? $model->end_year ?? null) }}" />
    </x-forms.field>

    <x-forms.field field="collapsed" css="col-span-2" :label="__('timelines/eras.fields.is_collapsed')">
        <input type="hidden" name="is_collapsed" value="0" />
        <x-checkbox :text="__('timelines/eras.helpers.is_collapsed')">
            <input type="checkbox" name="is_collapsed" value="1" @if (old('is_collapsed', $model->is_collapsed ?? false)) checked="checked" @endif />
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
