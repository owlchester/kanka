@if (!$user->hasPayPal())
    @if($currentPlan === \App\Models\Pledge::KOBOLD)
        <a class="btn2 btn-block btn-sm disabled">
            {{ __('tiers.current') }}
        </a>
    @else
        <a class="btn2 btn-block btn-sm btn-error " data-toggle="dialog" data-target="subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => 1]) }}">
            {{ __('settings.subscription.subscription.actions.cancel') }}
        </a>
    @endif
@endif
