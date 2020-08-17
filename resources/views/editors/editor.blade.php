@if(auth()->user()->editor == 'summernote')
    @renderOnce('editors-summernote')
        @include('editors.summernote')
    @endrenderOnce
@else
@include('editors.tinymce')
@endif
