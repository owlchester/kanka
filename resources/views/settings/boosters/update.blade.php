<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<div class="modal-body text-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>

    <h4 class="mt-0">
        {!! __('settings/boosters.superboost.title', ['campaign' => $campaign->name]) !!}
    </h4>


    <div class="booster-icon rounded-full">
        <i class="fa-solid fa-rocket fa-2x" aria-hidden="true"></i>
    </div>

    @if ($campaign->superboosted())
        <p>{!! __('settings/boosters.superboost.errors.boosted', ['campaign' => $campaign->name])!!}</p>
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
                <a href="{{ route('settings.subscription') }}" class="btn bg-maroon rounded-full px-8">
                    {!! __('settings/boosters.boost.actions.upgrade') !!}
                </a>
            </div>
        @else
            <p class="my-1">
                {{ __('settings/boosters.boost.pitch') }}
            </p>

            <div class="text-center my-5">
                <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-maroon rounded-full px-8 mr-5">
                    {!! __('callouts.booster.learn-more') !!}
                </a>
                <a href="{{ route('settings.subscription') }}" class="btn bg-maroon rounded-full px-8">
                    {!! __('settings/boosters.boost.actions.subscribe') !!}
                </a>
            </div>
        @endsubscriber
    @else

        <p class="my-5">
            {!! __('settings/boosters.superboost.upgrade', [
    'cost' => '<code>' . $cost . '</code>',
    'campaign' => '<strong>' . $campaign->name . '</strong>'
    ])!!}
        </p>
        <p class="my-5">{{ __('settings/boosters.boost.duration') }}</p>

       {!! Form::model($boost, ['route' => ['campaign_boosts.update', $boost], 'method' => 'PATCH']) !!}
        <div class="pb-5">
            <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">
                {{ __('crud.cancel') }}
            </button>
            <button type="submit" class="btn bg-maroon px-8 ml-5 rounded-full">
                <span class="fa-solid fa-rocket" aria-hidden="true"></span>
                <span class="">{{ __('settings/boosters.superboost.actions.confirm') }}</span>
            </button>
        </div>
        {!! Form::hidden('action', 'superboost') !!}
        {!! Form::hidden('campaign_id', $campaign->id) !!}
        {!! Form::close() !!}
    @endif
</div>
