@php $currentCampaign = isset($campaign) && $campaign instanceof \App\Models\Campaign ? $campaign : $campaignService->campaign() @endphp
<div class="grid gap-5 grid-cols-1 @if (!isset($skipImage)) lg:grid-cols-2 booster-block mb-5 @endif ">
        <div class="px-8 py-5 rounded-xl text-center text-base border-boost border-1 border-solid bg-box">

            @include ('partials.boost_icon')

            <h4>{{ __('campaigns/limits.title') }}</h4>

            @foreach ([__('campaigns/limits.' . $key)] as $text)
                <p class="mb-5">{!! $text !!}</p>
            @endforeach

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
    @if (!isset($skipImage))
    <div class="">
        @include('partials.images.boosted-image')
    </div>
    @endif
</div>
