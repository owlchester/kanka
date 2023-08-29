<x-grid type="1/1">
    <x-forms.field
        field="entity-type"
        :required="true"
        :label="__('crud.fields.entity_type')">
        {!! Form::select('entity_type', $entities, [], ['class' => 'w-full']) !!}
    </x-forms.field>

    <x-forms.field
        field="file"
        :required="true"
        :label="__('entities/files.fields.file')">
        {!! Form::file('default_entity_image', ['class' => 'image w-full']) !!}
    </x-forms.field>
</x-grid>
