<div class="flex gap-2 mb-2 items-center align-center">
    <div class="flex-0">
        @include ('partials.boost_icon')
    </div>
    <div>
        <p class="">{{ __('callouts.booster.multiple') }}</p>

        @subscriber()
        <a href="{{ route('settings.boost', ['campaign' => $campaignService->campaign()]) }}" class="btn bg-boost text-white btn-sm" target="_blank">
            {!! __('callouts.booster.actions.boost', ['campaign' => $campaignService->campaign()->name]) !!}
        </a>
        @else
            <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-boost text-white btn-sm">
                {!! __('callouts.booster.learn-more') !!}
            </a>
        @endif
    </div>
</div>
