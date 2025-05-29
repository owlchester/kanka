<?php /** @var \App\Models\Ability $model */?>

<x-helper>
    <p>{{ __('abilities.children.create.helper', ['name' => $model->name]) }}</p>
</x-helper>

<x-grid type="1/1">
    <x-forms.foreign
        field="entities"
        required
        label="entities.entities"
        multiple="multiple"
        name="entities[]"
        id="entities[]"
        :campaign="$campaign"
        :route="route('search.ability-entities', [$campaign, 'exclude-entity' => $model->entity->id])"
    >
    </x-forms.foreign>

    @include('cruds.fields.visibility_id', ['model' => null])
</x-grid>
