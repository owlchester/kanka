<x-form :action="['billing.payment-method.save']" method="PATCH">
    @include('partials.forms._dialog', [
        'title' => __('settings.subscription.currency.title'),
        'content' => 'settings.subscription.currency.' . $content,
        'submit' => __('settings.subscription.actions.update_currency'),
    ])
    <input type="hidden" name="from" value="{{ 'settings.subscription' }}" />
</x-form>
