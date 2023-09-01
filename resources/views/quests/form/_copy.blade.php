<x-forms.field
    field="copy-posts">
    {!! Form::hidden('copy_elements', null) !!}
    <x-checkbox :text="__('quests.fields.copy_elements')">
        {!! Form::checkbox('copy_elements', 1, true) !!}
    </x-checkbox>
</x-forms.field>
