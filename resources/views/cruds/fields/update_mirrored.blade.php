<x-forms.field field="mirror" :label="__('entities/relations.bulk.fields.update_mirrored')">
    <input type="hidden" name="update_mirrored" value="0"/>
    <x-checkbox :text="__('entities/relations.bulk.helpers.update_mirrored')">
        {!! Form::checkbox('update_mirrored', 1)!!}
    </x-checkbox>
</x-forms.field>
