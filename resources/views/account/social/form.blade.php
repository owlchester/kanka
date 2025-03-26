<x-form :action="['account.social-save']" method="PATCH">
    @include('partials.forms._dialog', [
        'title' => __('account/social.title'),
        'content' => 'account.social._form',
    ])
</x-form>
