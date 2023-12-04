<?php /** @var \App\Models\Tag $model */?>
{{ csrf_field() }}
<x-grid type="1/1">
    <x-forms.foreign
        field="entities"
        :required="true"
        label="abilities.show.tabs.entities"
        multiple="multiple"
        name="entities[]"
        id="entities[]"
        :campaign="$campaign"
        :route="route('search.tag-children', [$campaign, 'exclude-entity' => true])"
    >
    </x-forms.foreign>
</x-grid>


