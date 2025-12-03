
<div id="family-tree">
    <family-tree
        permission="{{ auth()->check() && auth()->user()->can('update', $family->entity) }}"
        api="{{ route('families.family-tree.api', [$campaign, $family]) }}"
        save_api="{{ route('families.family-tree.api-save', [$campaign, $family]) }}"
        entity_api="{{ route('families.family-tree.entity-api', [$campaign, 0]) }}"
        search_api="{{ route('search.entities-with-relations', [$campaign, 'only' => config('entities.ids.character')]) }}"
        subscribe_url="{{ route('settings.subscription', ['f' => 'cta', 'w' => $campaign->id]) }}"
    >
    </family-tree>
</div>

@section('scripts')
    @parent
    @vite('resources/js/family-tree-vue.js')
@endsection
@section('styles')
    @parent
    @vite('resources/css/families/tree.css')
@endsection
