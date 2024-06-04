<x-forms.field field="copy-elements" :label="__('maps/markers.fields.copy_elements')">
    <x-checkbox :text="__('maps/markers.helpers.copy_elements')">
        <input type="checkbox" name="copy_related_elements" value="1" @if (old('copy_related_elements', true)) checked="checked" @endif />
    </x-checkbox>>
</x-forms.field>
