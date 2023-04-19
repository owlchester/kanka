<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<div class="modal-body text-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>

    <h4 class="my-5">
        {!! __('settings/premium.actions.unlock') !!}
    </h4>

    @if ($campaign->premium())
        <p>{!! __('settings/premium.create.errors.boosted', ['campaign' => $campaign->name])!!}</p>
    @elseif(auth()->user()->availableBoosts() < 4)
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
                {{ __('settings/premium.create.pitch') }}
            </p>

            <div class="text-center my-5">
                <a href="{{ route('front.premium') }}" target="_blank" class="btn bg-boost text-white rounded-full px-8 mr-5">
                    {!! __('callouts.premium.learn-more') !!}
                </a>
                <a href="{{ route('settings.subscription') }}" class="btn bg-boost text-white rounded-full px-8">
                    {!! __('settings/boosters.boost.actions.subscribe') !!}
                </a>
            </div>
        @endsubscriber

    @else

        <p class="my-5">
            {!! __('settings/premium.create.confirm', [
    'campaign' => '<strong>' . $campaign->name . '</strong>'
    ])!!}
        </p>
        <p class="my-5">{{ __('settings/premium.create.duration') }}</p>

       {!! Form::open(['route' => ['campaign_boosts.store']]) !!}
        <div class="pb-5 flex gap-5 justify-center">
            <button type="button" class="btn px-8 rounded-full " data-dismiss="modal">
                {{ __('crud.cancel') }}
            </button>
            <button type="submit" class="btn bg-boost text-white px-8 rounded-full">
                <span class="">{{ __('settings/premium.create.actions.confirm') }}</span>
            </button>
        </div>
        {!! Form::hidden('campaign_id', $campaign->id) !!}
        {!! Form::close() !!}
    @endif
</div>
