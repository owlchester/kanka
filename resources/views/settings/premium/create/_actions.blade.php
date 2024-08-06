@if ($campaign->boosted())
        <?php return; ?>
@elseif (auth()->user()->availableBoosts() < 1)
        <?php return; ?>
@endif
<button type="submit" class="btn2 btn-primary">
    <span class="fa-solid fa-gem" aria-hidden="true"></span>
    <span class="">{{ __('settings/premium.create.actions.confirm') }}</span>
</button>
