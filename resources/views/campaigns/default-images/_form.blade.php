<x-grid type="1/1">
    <x-forms.field
        field="entity-type"
        :required="true"
        :label="__('crud.fields.entity_type')">

        <x-forms.select name="entity_type" :options="$entities" class="w-full" />
    </x-forms.field>

    <x-forms.field
        field="file"
        :required="true"
        :label="__('entities/files.fields.file')">
        <input type="file" name="default_entity_image" class="image w-full" accept=".jpg, .jpeg, .png, .gif, .webp" />
    </x-forms.field>
</x-grid>
