<div
    class="flex gap-1 items-start"
    id="entities-explorer"
    data-mode="{{ $mode }}"
    data-api="{{ route('entities.index-api', $apiParams) }}"
    data-module="{{ $title }}"
></div>

@section('scripts')
    @parent
    @vite(['resources/js/entities/explore.js'])
@endsection
