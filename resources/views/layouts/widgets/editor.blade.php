@if (Auth::user()->editor == 'summernote')
    @include('layouts.widgets.summernote')
@else
    @include('layouts.widgets.tinymce')
@endif