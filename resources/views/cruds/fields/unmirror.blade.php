<x-forms.field field="unmirror" :label="__('entities/relations.bulk.fields.unmirror')">
    {!! Form::hidden('unmirror', 0) !!}
    <x-checkbox :text="__('entities/relations.bulk.helpers.unmirror')">
        {!! Form::checkbox('unmirror', 1)!!}
    </x-checkbox>
</x-forms.field>
