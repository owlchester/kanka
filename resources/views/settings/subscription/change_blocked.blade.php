<?php /** @var \App\User $user */ ?>
<x-dialog.header>
    {{ __('settings.subscription.change.title') }}
</x-dialog.header>

<article class="text-center max-w-xl container">
    <x-alert type="warning" class="w-full text-left">
        {{ __('subscription.errors.grace', ['date' => $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y')]) }}
    </x-alert>

</article>
