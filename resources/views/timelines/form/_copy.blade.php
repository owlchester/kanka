<x-forms.field
    field="copy-eras">
    {!! Form::hidden('copy_eras', null) !!}
    <label>
        {!! Form::checkbox('copy_eras', 1, true) !!}
        {{ __('timelines.fields.copy_eras') }}
    </label>
</x-forms.field>

<x-forms.field
    field="copy-elements">
    {!! Form::hidden('copy_elements', null) !!}
    <label>
        {!! Form::checkbox('copy_elements', 1, true) !!}
        {{ __('timelines.fields.copy_elements') }}
    </label>
</x-forms.field>
