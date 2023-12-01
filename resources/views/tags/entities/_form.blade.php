<?php /** @var \App\Models\Tag $model */?>
{{ csrf_field() }}
<x-grid type="1/1">
    <x-forms.field field="entities" :required="true" >
        @include('components.form.entities', ['options' => ['exclude-entity' => $model->entity->id, 'route' => 'search.tag-children']])
    </x-forms.field>
</x-grid>


