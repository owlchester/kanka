<x-forms.field
    field="copy-eras">
    {!! Form::hidden('copy_eras', null) !!}
    <x-checkbox :text="__('timelines.fields.copy_eras')">
        {!! Form::checkbox('copy_eras', 1, true) !!}
    </x-checkbox>
</x-forms.field>

<x-forms.field
    field="copy-elements">
    {!! Form::hidden('copy_elements', null) !!}
    <x-checkbox :text="__('timelines.fields.copy_elements')">
        {!! Form::checkbox('copy_elements', 1, true) !!}
    </x-checkbox>
</x-forms.field>
