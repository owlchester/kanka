<x-form :action="['account.password-save']" method="PATCH">
    @include('partials.forms._dialog', [
        'title' => __('account/password.title'),
        'content' => 'account.password._form',
        'dialog' => true,
    ])
</x-form>
