<x-grid type="1/1">
    <x-forms.field field="currency" :label="__('settings.subscription.fields.currency')">
        {!! Form::select('currency', ['' => __('settings.subscription.currencies.usd'), 'eur' => __('settings.subscription.currencies.eur')], null, ['class' => '']) !!}
    </x-forms.field>
</x-grid>
