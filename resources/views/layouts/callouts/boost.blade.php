@php $currentCampaign = isset($campaign) && $campaign instanceof \App\Models\Campaign ? $campaign : $campaignService->campaign() @endphp
<div class="grid gap-5 grid-cols-1 lg:grid-cols-2 booster-block mb-5">
    <div class="">
        <div class="booster-callout">
            <div class="booster-icon rounded-full">
                <i class="fa-solid fa-rocket fa-2x" aria-hidden="true"></i>
            </div>

            <h4>{{ __('callouts.booster.titles.' . (isset($superboost) ? 'superboosted' : 'boosted')) }}</h4>
            @foreach ($texts as $text)
                <p>{!! $text !!}</p>
            @endforeach

            <p>{{ __('callouts.booster.limitations.' . (isset($superboost) ? 'superboosted' : 'boosted')) }}</p>
            @subscriber()
                @if (isset($superboost))
                    <a href="{{ route('settings.boost', ['campaign' => $currentCampaign, 'superboost' => true]) }}" class="btn bg-maroon btn-lg">
                        {!! __('callouts.booster.actions.superboost', ['campaign' => $currentCampaign->name]) !!}
                    </a>
                @else
                    <a href="{{ route('settings.boost', ['campaign' => $currentCampaign]) }}" class="btn bg-maroon btn-lg">
                        {!! __('callouts.booster.actions.boost', ['campaign' => $currentCampaign->name]) !!}
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
