<div id="abilities">
    <abilities
            id="{{ $entity->id }}"
            api="{{ route('entities.entity_abilities.api', [$campaign, $entity]) }}"
            permission="{{ auth()->check() && auth()->user()->can('update', $entity->child) }}"
            trans="{{ $translations }}"
    ></abilities>
</div>

@section('scripts')
    @parent
    @vite('resources/js/abilities.js')
@endsection

@section('styles')
    @parent
    @vite('resources/sass/abilities.scss')
@endsection
