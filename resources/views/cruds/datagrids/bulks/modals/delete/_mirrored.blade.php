<p>
<x-forms.field field="delete-mirror" :label="__('entities/relations.bulk.fields.delete_mirrored')">
    {!! Form::hidden('delete_mirrored', 0) !!}
    <label class="flex gap-2 text-neutral-content">
        {!! Form::checkbox('delete_mirrored', 1)!!}
        {{ __('entities/relations.bulk.helpers.delete_mirrored') }}
    </label>
</x-forms.field>
</p>
