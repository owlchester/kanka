<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<div class="modal-body text-center">
    <x-dialog.close :modal="true" />

    <h4 class="my-5">
        {!! __('settings/premium.actions.unlock') !!}
    </h4>

    @if ($campaign->premium())
        <p>{!! __('settings/premium.create.errors.boosted', ['campaign' => $campaign->name])!!}</p>
    @elseif(auth()->user()->availableBoosts() < 1)
        @subscriber
            <p class="my-1">
                {!! __('settings/boosters.boost.errors.out-of-boosters', [
                    'upgrade' => link_to_route('settings.subscription', __('settings/boosters.boost.upgrade')),
                    'cost' => '<code>' . 1 . '</code>',
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
        <x-dialog.footer :modal="true">
            <button type="submit" class="btn2 btn-primary">
                <span class="">{{ __('settings/premium.create.actions.confirm') }}</span>
            </button>
        </x-dialog.footer>
        {!! Form::hidden('campaign_id', $campaign->id) !!}
        {!! Form::close() !!}
    @endif
</div>
