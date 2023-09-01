<x-forms.field field="mirror" :label="__('entities/relations.bulk.fields.update_mirrored')">
    {!! Form::hidden('update_mirrored', 0) !!}
    <x-checkbox :text="__('entities/relations.bulk.helpers.update_mirrored')">
        {!! Form::checkbox('update_mirrored', 1)!!}
    </x-checkbox>
</x-forms.field>
