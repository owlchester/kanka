<x-forms.field
    field="closed"
    :label="__('crud.fields.closed')">
    {!! Form::hidden('is_closed', 0) !!}
    <x-checkbox :text="__('crud.fields.is_closed')">
        {!! Form::checkbox('is_closed', 1, empty($model) ? false : $model->is_closed) !!}
    </x-checkbox>
</x-forms.field>
