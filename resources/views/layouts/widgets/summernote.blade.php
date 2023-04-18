<input type="hidden" id="mention-route-entities" value="{{ route('search.live') }}"/>
<input type="hidden" id="mention-route-months" value="{{ route('search.calendar-months') }}"/>

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js" defer></script>

    @vite(['resources/js/summernote.js'])
@endsection

@section('styles')
    <link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
@endsection
