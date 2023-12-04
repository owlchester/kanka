<?php /** @var \App\Models\Ability $model */?>
{{ csrf_field() }}

<x-grid type="1/1">
    <x-forms.foreign
        field="entities"
        :required="true"
        label="abilities.show.tabs.entities"
        multiple="multiple"
        name="entities[]"
        id="entities[]"
        :options="['exclude-entity' => $model->entity->id, 'route' => 'search.ability-entities']" 
        :campaign="$campaign"
        :route="route('search.ability-entities', [$campaign])"
    >
    </x-forms.foreign>

    @include('cruds.fields.visibility_id', ['model' => null])
</x-grid>
