<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<div class="modal-body text-center">
    <x-dialog.close :modal="true" />

    <h4 class="mt-0">
        {{ __('settings/boosters.unboost.title') }}
    </h4>

    <p class="py-5">{!! __('settings/boosters.unboost.warning', [
    'action' => $campaign->superboosted() ? __('settings/boosters.unboost.status.superboosting') : __('settings/boosters.unboost.status.boosting'),
    'campaign' => '<strong>' . $campaign->name . '</strong>'])!!}</p>

   {!! Form::open(['method' => 'DELETE', 'route' => ['campaign_boosts.destroy', $boost->id]]) !!}
        <x-dialog.footer :modal="true">

            <button type="submit" class="btn2 btn-error">
                <span class="">{{ __('settings/boosters.unboost.confirm') }}</span>
            </button>
        </x-dialog.footer>
    </div>
    {!! Form::close() !!}


</div>
