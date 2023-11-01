<x-forms.field field="copy-elements" :label="__('maps/markers.fields.copy_elements')">
    <x-checkbox :text="__('maps/markers.helpers.copy_elements')">
        {!! Form::checkbox('copy_related_elements', 1, true) !!}
    </x-checkbox>>
</x-forms.field>
