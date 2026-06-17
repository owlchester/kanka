<x-grid type="1/1">
    <x-forms.field field="role" :label="__('organisations.members.fields.role')">
        <input type="text" name="role" value="" placeholder="{{ __('organisations.members.placeholders.role') }}" maxlength="45" />
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['bulk' => true])
</x-grid>
