<?php /** @var \App\Models\Ability $model */?>
{{ csrf_field() }}

<x-grid type="1/1">
    <x-forms.foreign
        field="entities"
        required
        label="abilities.show.tabs.entities"
        multiple="multiple"
        name="entities[]"
        id="entities[]"
        :campaign="$campaign"
        :route="route('search.ability-entities', [$campaign, 'exclude-entity' => $model->entity->id])"
    >
    </x-forms.foreign>

    @include('cruds.fields.visibility_id', ['model' => null])
</x-grid>
