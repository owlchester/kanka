<x-grid type="1/1">
    <x-helper>
        <p>{{ __('account/password.subtitle') }}</p>
    </x-helper>

    <x-forms.field field="new-password" required :label="__('profiles.fields.new_password')" :helper="__('account/password.helpers.password')">
        <input type="password" name="password_new" placeholder="{{ __('profiles.placeholders.new_password') }}" autocomplete="new-password" />
    </x-forms.field>

    <x-forms.field field="password-confirm" required :label="__('profiles.fields.new_password_confirmation')" :helper="__('account/password.helpers.password-confirmation')">
        <input type="password" name="password_new_confirmation" placeholder="{{ __('profiles.placeholders.new_password_confirmation') }}" autocomplete="new-password" />
    </x-forms.field>
</x-grid>
