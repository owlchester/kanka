<x-forms.field field="mirror" :label="__('entities/relations.bulk.fields.update_mirrored')">
    {!! Form::hidden('update_mirrored', 0) !!}
    <label class="text-neutral-content cursor-pointer">
        {!! Form::checkbox('update_mirrored', 1)!!}
        {{ __('entities/relations.bulk.helpers.update_mirrored') }}
    </label>
</x-forms.field>
