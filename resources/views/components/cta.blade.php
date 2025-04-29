<div class="@if (request()->ajax()) max-w-2xl @endif p-5 rounded-xl text-center text-base bg-box shadow-xs flex flex-col gap-5">


    @if ($legacy)
        <h4 class="text-2xl">
            <x-icon class="fa-regular fa-rocket text-boost" />
            @if ($limit)
                {{ __('callouts.booster.limit') }}
            @elseif ($premium)
            {{ __('callouts.premium.title') }}
            @else
            {{ __('callouts.booster.titles.' . ($superboost ? 'superboosted' : 'boosted')) }}
            @endif
        </h4>

        <div class="grow flex flex-col gap-5">
            {!! $slot !!}

            @if (!$max)
                @if (!empty($cta))
                    <p>{!! $cta !!}</p>
                @elseif ($premium)
                    <p>{{ __('callouts.premium.limitation') }}</p>
                @elseif (!$minimal)
                <p>{{ __('callouts.booster.limitations.' . ($superboost ? 'superboosted' : 'boosted')) }}</p>
                @endif
            @endif
        </div>
        @if (!$max)
            @can('boost', auth()->user())
                @if ($superboost)
                    <a href="{{ route('settings.boost', ['campaign' => $campaign, 'superboost' => true]) }}" class="btn2 bg-boost text-white btn-block">
                        {!! __('callouts.booster.actions.superboost', ['campaign' => $campaign->name]) !!}
                    </a>
                @else
                    <a href="{{ route('settings.boost', ['campaign' => $campaign]) }}" class="btn2 bg-boost text-white btn-block">
                        {!! __('callouts.booster.actions.boost', ['campaign' => $campaign->name]) !!}
                    </a>
                @endif
            @else
                <a href="https://kanka.io/premium" target="_blank" class="btn2 bg-boost text-white btn-block">
                    {!! __('callouts.premium.learn-more') !!}
                </a>
            @endif
        @endif
    @else
        @if (!$minimal)
            <h4 class="text-2xl">

                @if (!$minimal)
                    <x-icon class="fa-regular fa-gem text-boost" />
                @endif

                {{ __('callouts.premium.title') }}
            </h4>
        @endif

            <div class="grow flex flex-col gap-5">
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
            @can('boost', auth()->user())
                <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="btn2 bg-boost text-white btn-block">
                    {!! __('callouts.premium.unlock', ['campaign' => $campaign->name]) !!}
                </a>
            @else
                <a href="https://kanka.io/premium" class="btn2 bg-boost text-white btn-block">
                    {!! __('callouts.premium.learn-more') !!}
                </a>
            @endif
        @endif
    @endif
</div>
