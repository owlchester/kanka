<div class="flex gap-1 items-start" id="entities-explorer">
    <entities-explorer
        api="{{ route('entities.index-api', array_merge([$campaign, $entityType], $parent ? ['parent_id' => $parent] : [])) }}"
        module="{{ $entityType->plural() }}"
        csrf="{{ csrf_token() }}"
    ></entities-explorer>
</div>

@section('scripts')
    @parent
    @vite(['resources/js/entities/explore.js'])
@endsection
