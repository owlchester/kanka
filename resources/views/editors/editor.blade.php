@if(auth()->user()->editor == 'legacy' || request()->get('_editor') == 'legacy')
    @include('editors.tinymce')
@else
    @once
    @include('editors.summernote')
    @endonce
@endif
