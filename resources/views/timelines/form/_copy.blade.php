<x-forms.field
    field="copy-eras">
    <input type="hidden" name="copy_eras" value="" />
    <x-checkbox :text="__('timelines.fields.copy_eras')">
        {!! Form::checkbox('copy_eras', 1, true) !!}
    </x-checkbox>
</x-forms.field>

<x-forms.field
    field="copy-elements">
    <input type="hidden" name="copy_elements" value="" />
    <x-checkbox :text="__('timelines.fields.copy_elements')">
        {!! Form::checkbox('copy_elements', 1, true) !!}
    </x-checkbox>
</x-forms.field>
