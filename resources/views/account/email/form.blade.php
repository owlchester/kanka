<x-form :action="['account.email-save']" method="PATCH">
    @include('partials.forms._dialog', [
        'title' => __('account/email.title'),
        'content' => 'account.email._form',
        'dialog' => true,
    ])
</x-form>
