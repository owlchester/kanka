<?php /** @var \App\Models\TierPrice $current */?>
@if (!$user->hasPayPal())
    @if(empty($current))
        <span class="btn2 btn-block">
            {{ __('tiers.current') }}
        </span>
    @else
        <a class="btn2 btn-block btn-error " data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => 1]) }}">
            {{ __('settings.subscription.subscription.actions.cancel') }}
        </a>
    @endif
@endif
