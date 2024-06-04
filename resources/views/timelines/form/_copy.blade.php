<x-forms.field
    field="copy-eras">
    <input type="hidden" name="copy_eras" value="" />
    <x-checkbox :text="__('timelines.fields.copy_eras')">
        <input type="checkbox" name="copy_eras" value="1" checked="checked" />
    </x-checkbox>
</x-forms.field>

<x-forms.field
    field="copy-elements">
    <input type="hidden" name="copy_elements" value="" />
    <x-checkbox :text="__('timelines.fields.copy_elements')">
        <input type="checkbox" name="copy_elements" value="1" checked="checked" />
    </x-checkbox>
</x-forms.field>
