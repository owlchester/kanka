<div class="flex gap-1 items-start" id="entities-explorer">
    <entities-explorer
        mode="{{ $mode }}"
        api="{{ route('entities.index-api', $apiParams) }}"
        module="{{ $title }}"
        csrf="{{ csrf_token() }}"
    ></entities-explorer>
</div>

@section('scripts')
    @parent
    @vite(['resources/js/entries/explore.js'])
@endsection
