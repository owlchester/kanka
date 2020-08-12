@if(auth()->user()->editor == 'summernote')
@include('editors.summernote')
@else
@include('editors.tinymce')
@endif
