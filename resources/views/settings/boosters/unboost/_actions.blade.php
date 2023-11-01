@if (!$boost->inCooldown())
    <button type="submit" class="btn2 btn-error">
        <span class="">{{ __('settings/boosters.unboost.confirm') }}</span>
    </button>
@endif
