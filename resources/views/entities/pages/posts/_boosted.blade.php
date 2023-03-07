<p class="mt-2">{{ __('callouts.booster.limitation') }}

@subscriber()
<a href="{{ route('settings.boost', ['campaign' => $campaignService->campaign()]) }}">
    {!! __('callouts.booster.actions.boost', ['campaign' => $campaignService->campaign()->name]) !!}
</a>
@else
    <a href="{{ route('front.boosters') }}">
        {!! __('callouts.booster.learn-more') !!}
    </a>
@endif
</p>

