@php 
    if ($filterService->single('connection_target')) {
        $model = \App\Models\Entity::find($filterService->single('connection_target'));
    }
@endphp

<x-grid>
    <x-forms.foreign
        field="connection_target"
        :required="false"
        label="entities/relations.filters.name"
        name="connection_target"
        id="connection_target"
        :campaign="$campaign"
        :route="route('search.entities-with-relations', [$campaign])"
        :selected="$model"
    >
    </x-forms.foreign>

    <x-forms.field field="filter-connection-name" :label="__('entities/relations.filters.connection')">
        <input type="text" class="w-full entity-list-filter" name="connection_name" value="{{ $filterService->single('connection_name') }}" />
    </x-forms.field>
</x-grid>