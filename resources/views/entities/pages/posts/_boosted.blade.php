<p>
    {!! __('callouts.premium.limitation', ['campaign' => $campaign->name]) !!}
    @can('boost', auth()->user())
        <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="text-link">
            {!! __('settings/premium.actions.unlock', ['campaign' => $campaign->name]) !!}
        </a>
    @else
        <a href="{{ \App\Facades\Domain::toFront('premium')  }}" class="text-link">
            {!! __('callouts.premium.learn-more') !!}
        </a>
    @endif
</p>

