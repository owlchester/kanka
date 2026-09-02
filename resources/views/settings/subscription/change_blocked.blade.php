<?php /** @var \App\Models\User $user */ ?>
<x-dialog.header>
    {{ __('settings.subscription.change.title') }}
</x-dialog.header>

<article class="text-center max-w-xl container p-4 md:px-6">
    <x-alert type="warning" class="w-full text-left">
        @if ($user->hasPayPal())
            {{ __('subscription.errors.legacy_paypal', ['date' => $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y')]) }}
        @else
            {{ __('subscription.errors.grace', ['date' => $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y')]) }}
        @endif
    </x-alert>

</article>
