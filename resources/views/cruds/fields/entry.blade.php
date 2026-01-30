@php
    $editor = auth()->user()->editor;
    if (request()->has('tiptap')) {
        $editor = 'tiptap';
    } elseif (request()->has('tinymce')) {
        $editor = 'legacy';
    } elseif (request()->has('summernote')) {
        $editor = '';
    }
    $fieldName = $fieldName ?? 'entry';
    $fieldNameForEdition = $fieldName . 'ForEdition';
@endphp

@if ($editor === 'tiptap')
    @include('editors.tiptap_editor', ['model' => $model, 'fieldName' => $fieldName])
@else
    <textarea
        id="{{ $fieldName }}"
        name="{{ $fieldName }}"
        class="w-full html-editor"
        rows="3">
        {!! FormCopy::field($fieldNameForEdition)->string() ?: old($fieldName, $model->{$fieldNameForEdition} ?? null) !!}
    </textarea>
@endif
