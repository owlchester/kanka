<?php /** @var \App\Models\User $user */ ?>
@php
    $endDate = $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y');
@endphp
<x-dialog.header>
    {{ __('subscriptions/renew.title') }}
</x-dialog.header>

<article class="text-center max-w-xl container">
    <x-grid type="1/1">
        <x-helper>
            <p class="text-left">
                {!! __('settings.subscription.cancel.grace.text', ['date' => '<span class="text-error">' . $endDate . '</span>'])!!}
            </p>
        </x-helper>
        <x-helper>
            <p class="text-left">
                {!! __('subscriptions/renew.helper')!!}
            </p>
        </x-helper>
    </x-grid>

    <x-form :action="['settings.subscription.renew']">

        <x-buttons.confirm type="primary">
            <x-icon class="fa-solid fa-repeat" />
            <span>
                {{ __('subscriptions/renew.actions.renew') }}
            </span>
        </x-buttons.confirm>
    </x-form>
</article>
