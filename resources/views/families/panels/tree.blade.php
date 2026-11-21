
<div
    id="family-tree"
    data-permission="{{ auth()->check() && auth()->user()->can('update', $family->entity) ? '1' : '0' }}"
    data-api="{{ route('families.family-tree.api', [$campaign, $family]) }}"
    data-save-api="{{ route('families.family-tree.api-save', [$campaign, $family]) }}"
    data-entity-api="{{ route('families.family-tree.entity-api', [$campaign, 0]) }}"
    data-search-api="{{ route('search.entities-with-relations', [$campaign, 'only' => config('entities.ids.character')]) }}"
    data-subscribe-url="{{ route('settings.subscription', ['f' => 'cta', 'w' => $campaign->id]) }}"
></div>

@section('scripts')
    @parent
    @vite('resources/js/family-tree-vue.js')
@endsection
@section('styles')
    @parent
    @vite('resources/css/families/tree.css')
@endsection
