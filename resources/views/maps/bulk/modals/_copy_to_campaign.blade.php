<x-forms.field field="copy-elements" :label="__('maps/markers.fields.copy_elements')">
    <label class="text-neutral-content cursor-pointer flex gap-2">
        {!! Form::checkbox('copy_related_elements', 1, true) !!}
        {{ __('maps/markers.helpers.copy_elements_to_campaign') }}
    </label>
</x-forms.field>
