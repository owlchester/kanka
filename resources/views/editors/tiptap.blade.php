
@section('scripts')
    @parent
    <script>window.tiptapTranslations = @json(__('tiptap.editor'));</script>
    @vite('resources/js/editors/tiptap/index.js')
@endsection
