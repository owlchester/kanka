<?php /** @var \App\Models\Ability $model */?>
{{ csrf_field() }}

<x-grid type="1/1">
    <x-forms.field field="entities" :required="true" >
        <x-form.entities 
            :options="['exclude-entity' => $model->entity->id, 'route' => 'search.ability-entities']" 
            :campaign="$campaign"
            :ajax="request()->ajax()"
        >
        </x-form.entities>
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => null])
</x-grid>
