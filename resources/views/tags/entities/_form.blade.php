<?php /** @var \App\Models\Tag $model */?>
<x-grid type="1/1">
    <x-forms.foreign
        field="entities"
        :required="true"
        label="abilities.show.tabs.entities"
        :multiple="true"
        name="entities[]"
        id="entities[]"
        :campaign="$campaign"
        :route="route('search.tag-children', [$campaign, 'exclude-entity' => $model->id])"
    >
    </x-forms.foreign>
</x-grid>


