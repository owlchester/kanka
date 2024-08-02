<x-forms.field field="copy-elements" :label="__('maps/markers.fields.copy_elements')">
    <x-checkbox :text="__('maps/markers.helpers.copy_elements_to_campaign')">
        <input type="checkbox" name="copy_elements" value="1" @if (old('copy_elements', true)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
