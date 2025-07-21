
<x-grid type="1/1">
    <x-forms.field
        field="name"
        required="true"
        label="{{ __('settings/api.clients.form.name') }}">
        <input type="text" name="name" placeholder="{{ __('settings/api.clients.form.name_placeholder') }}" maxlength="40" value="{{ $client->name ?? '' }}"/>
        <span class="text-sm text-neutral-content">
            {{ __('settings/api.clients.form.name_helper') }}
        </span>
    </x-forms.field>

    <x-forms.field
        field="redirect"
        required="true"
        label="{{ __('settings/api.clients.form.redirect') }}">
        <input type="text" name="redirect" placeholder="{{ __('settings/api.clients.form.redirect_placeholder') }}" maxlength="120" value="{{ $client->redirect ?? '' }}"/>
        <span class="text-sm text-neutral-content">
            {{ __('settings/api.clients.form.redirect_helper') }}
        </span>
    </x-forms.field>
</x-grid>
