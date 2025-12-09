@auth
    @if (isset($campaign) && !$campaign->boosted())
        @can('boost', auth()->user())
            <p>
                <a href="{{ route('settings.boost', ['campaign' => $campaign]) }}" class="text-link">
                    <x-icon class="premium" />
                    {!! __('callouts.subscribe.share-booster', ['campaign' => $campaign->name]) !!}
                </a>
            </p>
        @else
            <p>
                <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="text-link">
                    <x-icon class="premium" />
                    {!! __('callouts.subscribe.share-premium', ['campaign' => $campaign->name]) !!}
                </a>
            </p>
        @endif
    @endif
@else
    <a href="{{ \App\Facades\Domain::toFront('pricing') }}" class="text-link">{{ __('callouts.subscribe.pitch-image', ['max' => $max]) }}</a>
@endif
