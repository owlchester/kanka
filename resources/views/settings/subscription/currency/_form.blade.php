<x-grid type="1/1">
    @if (auth()->user()->subscription('kanka')?->ended())
        @include('settings.subscription.currency._reset')
    @endif

    <x-forms.field field="currency" :label="__('settings.subscription.fields.currency')">
        <x-forms.select name="currency" :options="$currencies" :selected="auth()->user()->currency()" />
    </x-forms.field>

    @if (auth()->user()->subscription('kanka')?->ended())
        <x-forms.field field="reset_billing" :required="true" :label=" __('settings.subscription.fields.reset')">
            <input type="hidden" name="reset_billing" value="0" />
            <x-checkbox :text="__('settings.subscription.fields.reset_billing')">
                <input type="checkbox" name="reset_billing" value="1" required/>
            </x-checkbox>
        </x-forms.field>
    @endif

</x-grid>
