<x-grid type="1/1">
<x-alert type="warning">
    <p>
        {!! __('settings.subscription.helpers.currency_block', ['email' => '<a href="mailto' . config('app.email') . '" class="text-link">' . config('app.email') . '</a>'])!!}
    </p>
</x-alert>
</x-grid>
