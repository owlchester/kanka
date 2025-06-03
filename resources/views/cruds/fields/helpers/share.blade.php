@can('boost', auth()->user())
    @if (isset($campaign) && !$campaign->boosted())
        @can('boost', auth()->user())
            <p>
                <a href="{{ route('settings.boost', ['campaign' => $campaign]) }}">
                    <x-icon class="premium" />
                    {!! __('callouts.subscribe.share-booster', ['campaign' => $campaign->name]) !!}
                </a>
            </p>
        @else
            <p>
                <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}">
                    <x-icon class="premium" />
                    {!! __('callouts.subscribe.share-premium', ['campaign' => $campaign->name]) !!}
                </a>
            </p>
        @endif
    @endif
@else
    <a href="{{ \App\Facades\Domain::toFront('pricing') }}">{{ __('callouts.subscribe.pitch-image', ['max' => $max]) }}</a>
@endif
