<x-forms.field
    field="copy-posts">
    {!! Form::hidden('copy_elements', null) !!}
    <label>
        {!! Form::checkbox('copy_elements', 1, true) !!}
        {{ __('quests.fields.copy_elements') }}
    </label>
</x-forms.field>
