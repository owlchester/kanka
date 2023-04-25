<p class="mt-2">{{ __('callouts.premium.limitation') }}

@subscriber()
<a href="{{ route('settings.premium', ['campaign' => $campaignService->campaign()]) }}">
    {!! __('settings/premium.actions.unlock', ['campaign' => $campaignService->campaign()->name]) !!}
</a>
@else
    <a href="{{ route('front.premium') }}">
        {!! __('callouts.premium.learn-more') !!}
    </a>
@endif
</p>

