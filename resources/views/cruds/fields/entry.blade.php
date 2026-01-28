@php
    $editor = auth()->user()->editor;
    if (request()->has('tiptap')) {
        $editor = 'tiptap';
    } elseif (request()->has('tinymce')) {
        $editor = 'legacy';
    } elseif (request()->has('summernote')) {
        $editor = '';
    }
@endphp

@if ($editor === 'tiptap')
    @include('editors.tiptap_editor')
@else
    <textarea
        id="entry"
        name="entry"
        class="w-full html-editor"
        rows="3">
        {!! FormCopy::field('entryForEdition')->string() ?: old('entry', $entity->entryForEdition ?? $model->entryForEdition ?? null) !!}
    </textarea>
@endif
