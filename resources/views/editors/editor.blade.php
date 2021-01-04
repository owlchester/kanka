@if(auth()->user()->editor == 'legacy')
    @include('editors.tinymce')
@else
    @renderOnce('editors-summernote')
    @include('editors.summernote')
    @endrenderOnce
@endif
