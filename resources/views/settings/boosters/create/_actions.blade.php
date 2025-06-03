@if ($campaign->boosted())
    <?php return; ?>
@elseif (auth()->user()->availableBoosts() < $cost)
    <?php return; ?>
@endif

<button type="submit" class="btn2 btn-primary">
    <x-icon class="fa-regular fa-rocket" />
    <span class="">{{ __('settings/boosters.' . ($superboost ? 'superboost' : 'boost') . '.actions.confirm') }}</span>
</button>
@if (isset($canSuperboost) && $canSuperboost)
    <button type="submit" class="btn2 btn-primary" name="superboost">
        <x-icon class="fa-regular fa-rocket" />
        <span class="">{!! __('settings/boosters.superboost.actions.instead', ['count' => '<strong>3</strong>']) !!}</span>
    </button>
@endif
