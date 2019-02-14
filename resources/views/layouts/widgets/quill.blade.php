<input type="hidden" id="mention-route-entities" value="{{ route('search.mentions') }}"/>
<input type="hidden" id="mention-route-months" value="{{ route('search.months') }}"/>

@section('scripts')
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="/vendor/quill-mention/quill.mention.min.js"></script>
    <script src="{{ mix('js/quill.js') }}" defer></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="//cdn.quilljs.com/1.3.6/quill.snow.css">
    <link rel="stylesheet" href="/vendor/quill-mention/quill.mention.min.css">
@endsection