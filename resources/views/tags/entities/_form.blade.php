<?php /** @var \App\Models\Tag $model */?>
{{ csrf_field() }}
<x-grid type="1/1">
    <x-forms.field field="entities" :required="true" >
        <x-form.entities 
            :options="['exclude-entity' => $model->entity->id, 'route' => 'search.tag-children']" 
            :campaign="$campaign"
            :ajax="request()->ajax()"
        >
        </x-form.entities>
    </x-forms.field>
</x-grid>


