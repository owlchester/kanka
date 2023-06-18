<div class="grid gap-5 grid-cols-1 @if ($image) lg:grid-cols-2 booster-block mb-5 @endif">
    <div class="max-w-2xl p-5 rounded text-center mb-5 text-base border-boost border-1 border-solid bg-box shadow-xs flex flex-col gap-1">

        @if (!$minimal)
            <div class="inline">
                @include ('partials.boost_icon')
            </div>
        @endif

        @if ($legacy)
            <h4 class="text-2xl my-3">
                @if ($limit)
                    {{ __('callouts.booster.limit') }}
                @else
                {{ __('callouts.booster.titles.' . ($superboost ? 'superboosted' : 'boosted')) }}
                @endif
            </h4>

            <div class="grow">
                {!! $slot !!}

                @if (!$max)
                    @if (!empty($cta))
                        <p>{!! $cta !!}</p>
                    @elseif (!$minimal)
                    <p>{{ __('callouts.booster.limitations.' . ($superboost ? 'superboosted' : 'boosted')) }}</p>
                    @endif
                @endif
            </div>
            @if (!$max)
                @subscriber()
                    @if ($superboost)
                        <a href="{{ route('settings.boost', ['campaign' => $campaign, 'superboost' => true]) }}" class="btn bg-boost text-white btn-lg btn-block">
                            {!! __('callouts.booster.actions.superboost', ['campaign' => $campaign->name]) !!}
                        </a>
                    @else
                        <a href="{{ route('settings.boost', ['campaign' => $campaign]) }}" class="btn bg-boost text-white btn-lg btn-block">
                            {!! __('callouts.booster.actions.boost', ['campaign' => $campaign->name]) !!}
                        </a>
                    @endif
                @else
                    <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-boost text-white btn-lg btn-block">
                        {!! __('callouts.booster.learn-more') !!}
                    </a>
                @endif
            @endif
        @else
            @if (!$minimal)
            <h4 class="text-2xl my-3">{{ __('callouts.premium.title') }}</h4>
            @endif

            <div class="grow">
                {!! $slot !!}

                @if (!$max)
                    @if (!empty($cta))
                        <p>{!! $cta !!}</p>
                    @elseif (!$minimal)
                        <p>{{ __('callouts.premium.limitation') }}</p>
                    @endif
                @endif
            </div>

            @if (!$max)
            @subscriber()
                <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="btn bg-boost text-white btn-lg btn-block">
                    {!! __('callouts.premium.unlock', ['campaign' => $campaign->name]) !!}
                </a>
            @else
                <a href="{{ route('front.premium') }}" class="btn bg-boost text-white btn-lg btn-block">
                    {!! __('callouts.premium.learn-more') !!}
                </a>
            @endif
            @endif
        @endif
    </div>
    @if ($image)
        <div class="">
            @include('partials.images.boosted-image')
        </div>
    @endif
</div>
