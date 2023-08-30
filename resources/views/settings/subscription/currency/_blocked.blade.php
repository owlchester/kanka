<x-grid type="1/1">
<x-alert type="warning">
    <p>
        {!! __('settings.subscription.helpers.currency_blocked', ['email' => link_to('mailto:' . config('app.email'), config('app.email'))])!!}
    </p>
</x-alert>
</x-grid>
