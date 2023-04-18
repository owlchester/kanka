<x-tutorial code="abilities" doc="https://docs.kanka.io/en/latest/entities/abilities.html">
    <p>{{ __('entities/abilities.show.helper') }}</p>
</x-tutorial>

<div id="abilities">
    <abilities
            id="{{ $entity->id }}"
            api="{{ route('entities.entity_abilities.api', $entity) }}"
            permission="{{ auth()->check() && auth()->user()->can('update', $entity->child) }}"
            trans="{{ $translations }}"
    ></abilities>
</div>
