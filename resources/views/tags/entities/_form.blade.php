<?php /** @var \App\Models\Tag $model */?>
<x-grid type="1/1">
    <x-helper>
        <p>{!! __('tags.children.create.helper', ['name' => $model->name]) !!}</p>
    </x-helper>
    <x-forms.foreign
        field="entities"
        required
        label="abilities.show.tabs.entities"
        :multiple="true"
        name="entities[]"
        id="entities[]"
        :campaign="$campaign"
        :route="route('search.tag-children', [$campaign, 'exclude-entity' => $model->id])"
    >
    </x-forms.foreign>
</x-grid>


