<x-form :action="['account.billing.info-save']" method="PATCH">
    @include('partials.forms._dialog', [
        'title' => __('billing/information.title'),
        'content' => 'account.billing.information._form',
        'dialog' => true,
        'submit' => __('settings.billing.save')
    ])
</x-form>
