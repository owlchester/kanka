<div
    id="abilities"
    data-entity-id="{{ $entity->id }}"
    data-api="{{ route('entities.entity_abilities.api', [$campaign, $entity]) }}"
    data-permission="{{ auth()->check() && auth()->user()->can('update', $entity) ? '1' : '0' }}"
></div>

@section('scripts')
    @parent
    @vite('resources/js/abilities.js')
@endsection
