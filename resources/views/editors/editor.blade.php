@if(auth()->user()->editor == 'legacy')
    @include('editors.tinymce')
@else
    @once
    @include('editors.summernote')
    @endonce
@endif
