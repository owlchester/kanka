<x-grid type="1/1">

@if ($campaign->boosted())
    <p>{!! __('settings/boosters.boost.errors.boosted', ['campaign' => $campaign->name])!!}</p>
@elseif(auth()->user()->availableBoosts() < $cost)
    @can('boost', auth()->user())
        <p class="">
            {!! __('settings/boosters.boost.errors.out-of-boosters', [
                'upgrade' => '<a href="' . route('settings.subscription') . '">' . __('settings/boosters.boost.upgrade') . '</a>',
                'cost' => '<code>' . $cost . '</code>',
                'available' => '<strong>' . auth()->user()->availableBoosts() . '</strong>'
            ]) !!}
        </p>

        <div class="text-center">
            <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">
                {{ __('crud.cancel') }}
            </button>
            <a href="{{ route('settings.subscription') }}" class="btn2 bg-boost text-white rounded-full px-8">
                {!! __('settings/boosters.boost.actions.upgrade') !!}
            </a>
        </div>
    @else
        <p class="">
            {{ __('settings/boosters.boost.pitch') }}
        </p>

        <div class="text-center ">
            <a href="{{ \App\Facades\Domain::toFront('premium')  }}" target="_blank" class="btn2 bg-boost text-white rounded-full px-8 mr-5">
                {!! __('callouts.booster.learn-more') !!}
            </a>
            <a href="{{ route('settings.subscription') }}" class="btn2 bg-boost text-white rounded-full px-8">
                {!! __('settings/boosters.boost.actions.subscribe') !!}
            </a>
        </div>
    @endif
@else
    <p class="">
        {!! __('settings/boosters.' . ($superboost ? 'superboost' : 'boost') . '.confirm', [
    'cost' => '<code>' . $cost . '</code>',
    'campaign' => '<strong>' . $campaign->name . '</strong>'
    ])!!}
    </p>
    <p class="">{{ __('settings/boosters.boost.duration') }}</p>
@endif
</x-grid>
