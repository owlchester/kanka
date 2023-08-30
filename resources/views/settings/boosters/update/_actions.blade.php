@if ($campaign->premium() || $boost->inCooldown())
        <?php return; ?>
@elseif (auth()->user()->availableBoosts() < $cost)
        <?php return; ?>
@endif
<button type="submit" class="btn2 btn-primary">
    <span class="fa-solid fa-rocket" aria-hidden="true"></span>
    <span class="">{{ __('settings/boosters.superboost.actions.confirm') }}</span>
</button>
