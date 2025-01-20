<?php /** @var \App\Models\User $user */ ?>
@php
    $endDate = $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y');
@endphp
<x-dialog.header>
    {{ __('settings.subscription.cancel.grace.title') }}
</x-dialog.header>

<article class="text-center max-w-xl container">
    <x-helper>
        <p class="text-left">
            {!! __('settings.subscription.cancel.grace.text', ['date' => '<span class="text-error">' . $endDate . '</span>'])!!}
        </p>
        <p class="text-left">
            {!! __('settings.subscription.cancel.grace.renew')!!}
        </p>
    </x-helper>

    <a class="btn2 btn-lg btn-block btn-primary btn-outline" data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.renew') }}">
        {{ __('settings.subscription.subscription.actions.renew') }}
    </a>
</article>
