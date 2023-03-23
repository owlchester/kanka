@php $currentCampaign = isset($campaign) && $campaign instanceof \App\Models\Campaign ? $campaign : $campaignService->campaign() @endphp
<div class="grid gap-5 grid-cols-1 lg:grid-cols-2 booster-block mb-5">

        <div class="px-8 py-5 rounded-xl text-center mb-5 text-base border-boost border-1 border-solid bg-box">
            @include ('partials.boost_icon')

            <h4 class="text-2xl my-3">{{ __('callouts.booster.titles.' . (isset($superboost) ? 'superboosted' : 'boosted')) }}</h4>
            @foreach ($texts as $text)
                <p>{!! $text !!}</p>
            @endforeach

            <p>{{ __('callouts.booster.limitations.' . (isset($superboost) ? 'superboosted' : 'boosted')) }}</p>
            @subscriber()
                @if (isset($superboost))
                    <a href="{{ route('settings.boost', ['campaign' => $currentCampaign, 'superboost' => true]) }}" class="btn bg-boost text-white btn-lg btn-block">
                        {!! __('callouts.booster.actions.superboost', ['campaign' => $currentCampaign->name]) !!}
                    </a>
                @else
                    <a href="{{ route('settings.boost', ['campaign' => $currentCampaign]) }}" class="btn bg-boost text-white btn-lg btn-block">
                        {!! __('callouts.booster.actions.boost', ['campaign' => $currentCampaign->name]) !!}
                    </a>
                @endif
            @else
                <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-boost text-white btn-lg btn-block">
                    {!! __('callouts.booster.learn-more') !!}
                </a>
            @endif
        </div>
    <div class="">
        @include('partials.images.boosted-image')
    </div>
</div>
