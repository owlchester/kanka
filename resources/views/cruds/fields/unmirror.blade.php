<x-forms.field field="unmirror" :label="__('entities/relations.bulk.fields.unmirror')">
    {!! Form::hidden('unmirror', 0) !!}
    <label class="text-neutral-content cursor-pointer">
        {!! Form::checkbox('unmirror', 1)!!}
        {{ __('entities/relations.bulk.helpers.unmirror') }}
    </label>
</x-forms.field>
