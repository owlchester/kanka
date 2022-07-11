@php $currentCampaign = $campaign instanceof \App\Models\Campaign ? $campaign : $campaignService->campaign() @endphp
<div class="grid gap-5 grid-cols-1 lg:grid-cols-2 booster-block mb-5">
    <div class="">
        <div class="booster-callout">
            <div class="booster-icon">
                <i class="fa-solid fa-rocket fa-2x" aria-hidden="true"></i>
            </div>

            @if (isset($superboost))
                <h4>{{ __('callouts.booster.titles.superboosted') }}</h4>
            @else
                <h4>{{ __('callouts.booster.titles.boosted') }}</h4>
            @endif
            @foreach ($texts as $text)
                <p>{!! $text !!}</p>
            @endforeach

            <p>{{ __('callouts.booster.limitation') }}</p>
            @subscriber()
                @if (isset($superboost))
                    <a href="{{ route('settings.boost', ['campaign' => $campaign, 'superboost' => true]) }}" class="btn bg-maroon btn-lg">
                        {!! __('callouts.booster.actions.superboost', ['campaign' => $campaign->name]) !!}
                    </a>
                @else
                    <a href="{{ route('settings.boost', ['campaign' => $campaign]) }}" class="btn bg-maroon btn-lg">
                        {!! __('callouts.booster.actions.boost', ['campaign' => $campaign->name]) !!}
                    </a>
                @endif
            @else
                <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-maroon btn-lg">
                    {!! __('callouts.booster.learn-more') !!}
                </a>
            @endif
        </div>
    </div>
    <div class="">
        @include('partials.images.boosted-image')
    </div>
</div>
