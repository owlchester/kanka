<?php /** @var \App\Models\Ability $model */?>
{{ csrf_field() }}

<x-grid type="1/1">
    <x-forms.field field="entities" :required="true" >
        @include('components.form.entities', ['options' => ['exclude-entity' => $model->entity->id]])
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => null])
</x-grid>
