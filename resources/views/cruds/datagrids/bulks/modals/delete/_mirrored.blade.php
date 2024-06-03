<p>
<x-forms.field field="delete-mirror" :label="__('entities/relations.bulk.fields.delete_mirrored')">
    <input type="hidden" name="delete_mirrored" value="0"/>
    <x-checkbox :text="__('entities/relations.bulk.helpers.delete_mirrored')">
        {!! Form::checkbox('delete_mirrored', 1)!!}
    </x-checkbox>
</x-forms.field>
</p>
