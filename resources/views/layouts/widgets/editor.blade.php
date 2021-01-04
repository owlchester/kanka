@if (Auth::user()->editor != 'legacy')
    @include('layouts.widgets.summernote')
@else
    @include('layouts.widgets.tinymce')
@endif
