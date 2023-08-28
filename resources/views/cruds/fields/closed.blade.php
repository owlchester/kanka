<x-forms.field
    field="closed"
    :label="__('crud.fields.closed')">
    {!! Form::hidden('is_closed', 0) !!}
    <label class="font-normal text-neutral-content m-0">
        {!! Form::checkbox('is_closed', 1, empty($model) ? false : $model->is_closed) !!}
        {!! __('crud.fields.is_closed') !!}
    </label>
</x-forms.field>
