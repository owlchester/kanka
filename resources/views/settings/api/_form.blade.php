
<x-grid type="1/1">
    <x-forms.field
        field="name"
        required="true"
        label="{{ __('settings/api.tokens.form.name') }}">
        <input type="text" name="name" placeholder="{{ __('settings/api.tokens.form.name_placeholder') }}" maxlength="40" />
    </x-forms.field>
</x-grid>
