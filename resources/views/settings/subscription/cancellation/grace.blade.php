<?php /** @var \App\Models\User $user */ ?>
@php
    $endDate = $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y');
@endphp
<x-dialog.header>
    {{ __('settings.subscription.cancel.grace.title') }}
</x-dialog.header>

<article class="text-center max-w-xl container p-4 md:px-6">

    <x-helper>
        <p class="text-left">
            {!! __('settings.subscription.cancel.grace.text', ['date' => '<span class="text-error">' . $endDate . '</span>'])!!}
        </p>
    </x-helper>
</article>
