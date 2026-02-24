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
    @once
        @include('editors.tiptap')
    @endonce
@elseif($editor === 'legacy')
    @include('editors.tinymce')
@else
    @once
    @include('editors.summernote')
    @endonce
@endif
