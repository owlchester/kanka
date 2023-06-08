<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<div class="modal-body text-center">
    <x-dialog.close />

    <h4 class="mt-0">
        {!! __('settings/boosters.' . ($superboost ? 'superboost' : 'boost') . '.title', ['campaign' => $campaign->name]) !!}
    </h4>

    @include ('partials.boost_icon')

    @if ($campaign->boosted())
        <p>{!! __('settings/boosters.boost.errors.boosted', ['campaign' => $campaign->name])!!}</p>
    @elseif(auth()->user()->availableBoosts() < $cost)
        @subscriber
            <p class="my-1">
                {!! __('settings/boosters.boost.errors.out-of-boosters', [
                    'upgrade' => link_to_route('settings.subscription', __('settings/boosters.boost.upgrade')),
                    'cost' => '<code>' . $cost . '</code>',
                    'available' => '<strong>' . auth()->user()->availableBoosts() . '</strong>'
                ]) !!}
            </p>

            <div class="text-center my-5">
                <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">
                    {{ __('crud.cancel') }}
                </button>
                <a href="{{ route('settings.subscription') }}" class="btn bg-boost text-white rounded-full px-8">
                    {!! __('settings/boosters.boost.actions.upgrade') !!}
                </a>
            </div>
        @else
            <p class="my-1">
                {{ __('settings/boosters.boost.pitch') }}
            </p>

            <div class="text-center my-5">
                <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-boost text-white rounded-full px-8 mr-5">
                    {!! __('callouts.booster.learn-more') !!}
                </a>
                <a href="{{ route('settings.subscription') }}" class="btn bg-boost text-white rounded-full px-8">
                    {!! __('settings/boosters.boost.actions.subscribe') !!}
                </a>
            </div>
        @endsubscriber

    @else

        <p class="my-5">
            {!! __('settings/boosters.' . ($superboost ? 'superboost' : 'boost') . '.confirm', [
    'cost' => '<code>' . $cost . '</code>',
    'campaign' => '<strong>' . $campaign->name . '</strong>'
    ])!!}
        </p>
        <p class="my-5">{{ __('settings/boosters.boost.duration') }}</p>

       {!! Form::open(['route' => ['campaign_boosts.store']]) !!}
        <div class="pb-5 flex gap-5 justify-center">
            <button type="button" class="btn px-8 rounded-full " data-dismiss="modal">
                {{ __('crud.cancel') }}
            </button>
            <button type="submit" class="btn bg-boost text-white px-8 rounded-full">
                <span class="fa-solid fa-rocket" aria-hidden="true"></span>
                <span class="">{{ __('settings/boosters.' . ($superboost ? 'superboost' : 'boost') . '.actions.confirm') }}</span>
            </button>
            @if (isset($canSuperboost) && $canSuperboost)
                <button type="submit" class="btn bg-boost text-white px-8 rounded-full" name="superboost">
                    <span class="fa-solid fa-rocket" aria-hidden="true"></span>
                    <span class="">{!! __('settings/boosters.superboost.actions.instead', ['count' => '<strong>3</strong>']) !!}</span>
                </button>
            @endif
        </div>
        {!! Form::hidden('action', $superboost ? 'superboost' : 'boost') !!}
        {!! Form::hidden('campaign_id', $campaign->id) !!}
        {!! Form::close() !!}
    @endif
</div>
