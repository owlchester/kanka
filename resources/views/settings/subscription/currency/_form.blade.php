<x-grid type="1/1">
    <x-forms.field field="currency" :label="__('settings.subscription.fields.currency')">
        <x-forms.select name="currency" :options="$currencies" :selected="auth()->user()->currency()" />
    </x-forms.field>
</x-grid>
