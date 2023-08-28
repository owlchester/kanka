<x-grid>
    <x-forms.field field="filter-name" :label="__('entities/attributes.filters.name')">
        <input type="text" class="form-control entity-list-filter" name="attribute_name" value="{{ $filterService->single('attribute_name') }}" />
    </x-forms.field>
    <x-forms.field field="filter-value" :label="__('entities/attributes.filters.value')">
        <input type="text" class="form-control entity-list-filter" name="attribute_value" value="{{ $filterService->single('attribute_value') }}" />
    </x-forms.field>
</x-grid>

