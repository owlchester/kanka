
<x-grid type="1/1">
    <x-forms.field
        field="name"
        required="true"
        label="Client name">
        <input type="text" name="name" placeholder="Name of the client" maxlength="40" value="{{ $client->name ?? '' }}"/>
        <span class="text-sm text-neutral-content">
            Something your users will recognize and trust.
        </span>
    </x-forms.field>

    <x-forms.field
        field="redirect"
        required="true"
        label="Redirect URL">
        <input type="text" name="redirect" placeholder="Name the token" maxlength="120" value="{{ $client->redirect ?? '' }}"/>
        <span class="text-sm text-neutral-content">
            Your application's authorization callback URL.
        </span>
    </x-forms.field>
</x-grid>
