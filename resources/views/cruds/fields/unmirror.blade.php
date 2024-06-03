<x-forms.field field="unmirror" :label="__('entities/relations.bulk.fields.unmirror')">
    <input type="hidden" name="unmirror" value="0"/>
    <x-checkbox :text="__('entities/relations.bulk.helpers.unmirror')">
        {!! Form::checkbox('unmirror', 1)!!}
    </x-checkbox>
</x-forms.field>
