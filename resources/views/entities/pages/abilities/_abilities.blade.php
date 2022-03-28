<div class="box box-solid entity-abilities-box">
    <div class="box-body">
        <p class="help-block entity-abilities-helper">
            {{ __('entities/abilities.show.helper') }}
        </p>
    </div>
</div>

<div id="abilities">
    <abilities
            id="{{ $entity->id }}"
            api="{{ route('entities.entity_abilities.api', $entity) }}"
            permission="{{ auth()->check() && auth()->user()->can('update', $entity->child) }}"
            trans="{{ $translations }}"
    ></abilities>
</div>
