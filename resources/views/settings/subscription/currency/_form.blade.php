<x-grid type="1/1">
    <x-forms.field field="currency" :label="__('settings.subscription.fields.currency')">
        {!! Form::select('currency', $currencies, auth()->user()->currency(), ['class' => '']) !!}
    </x-forms.field>
</x-grid>
