<p>
<x-forms.field field="delete-mirror" :label="__('entities/relations.bulk.fields.delete_mirrored')">
    {!! Form::hidden('delete_mirrored', 0) !!}
    <x-checkbox :text="__('entities/relations.bulk.helpers.delete_mirrored')">
        {!! Form::checkbox('delete_mirrored', 1)!!}
    </x-checkbox>
</x-forms.field>
</p>
