@if ($campaign->boosted())
        <?php return; ?>
@elseif (auth()->user()->availableBenefits() < 1)
    <a href="{{ route('settings.subscription', ['w' => $campaign]) }}" class="btn2 btn-primary">
        {!! __('settings/boosters.boost.actions.upgrade') !!}
        <x-icon class="fa-regular fa-arrow-right" />
    </a>
@else
    <button type="submit" class="btn2 btn-primary">
        <x-icon class="premium" />
        <span class="">{{ __('settings/premium.create.actions.confirm') }}</span>
    </button>
@endif
