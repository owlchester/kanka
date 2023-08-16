<p class="mt-2">{{ __('callouts.premium.limitation') }}

@subscriber()
<a href="{{ route('settings.premium', ['campaign' => $campaign]) }}">
    {!! __('settings/premium.actions.unlock', ['campaign' => $campaign->name]) !!}
</a>
@else
    <a href="{{ \App\Facades\Domain::toFront('premium')  }}">
        {!! __('callouts.premium.learn-more') !!}
    </a>
@endif
</p>

