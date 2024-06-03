<x-forms.field
    field="copy-posts">
    <input type="hidden" name="copy_elements" />
    <x-checkbox :text="__('quests.fields.copy_elements')">
        {!! Form::checkbox('copy_elements', 1, true) !!}
    </x-checkbox>
</x-forms.field>
