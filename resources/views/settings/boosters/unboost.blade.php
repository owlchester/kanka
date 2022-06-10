<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<div class="modal-body text-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>

    <h4 class="mt-0">
        {{ __('settings/boosters.unboost.title') }}
    </h4>

    <p class="py-5">{!! __('settings/boosters.unboost.warning', [
    'action' => $campaign->superboosted() ? __('settings/boosters.unboost.status.superboosting') : __('settings/boosters.unboost.status.boosting'),
    'campaign' => '<strong>' . $campaign->name . '</strong>'])!!}</p>

   {!! Form::open(['method' => 'DELETE', 'route' => ['campaign_boosts.destroy', $boost->id]]) !!}
    <div class="pb-5">
        <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">
            {{ __('crud.cancel') }}
        </button>
        <button type="submit" class="btn btn-danger px-8 ml-5 rounded-full">
            <span class="">{{ __('settings/boosters.unboost.confirm') }}</span>
        </button>
    </div>
    {!! Form::close() !!}


</div>
