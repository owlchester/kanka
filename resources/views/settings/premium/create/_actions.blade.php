@if ($campaign->boosted())
        <?php return; ?>
@elseif (auth()->user()->availableBoosts() < 1)
        <?php return; ?>
@endif
<button type="submit" class="btn2 btn-primary">
    <x-icon class="premium" />
    <span class="">{{ __('settings/premium.create.actions.confirm') }}</span>
</button>
