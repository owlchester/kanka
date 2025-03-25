<x-grid type="1/1">
    <x-helper>{{ __('account/email.subtitle') }}</x-helper>

    <x-forms.field field="email" required :label="__('account/email.fields.email')" :helper="__('account/email.helpers.email')">
        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="{{ __('profiles.placeholders.email') }}" autocomplete="email" />
    </x-forms.field>
</x-grid>
