<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<div class="modal-body text-center">
    <x-dialog.close />

    <h4 class="mt-0">
        {{ __('settings/premium.remove.title') }}
    </h4>

    <p class="py-5">{!! __('settings/premium.remove.warning', [
    'campaign' => '<strong>' . $campaign->name . '</strong>'])!!}</p>

   {!! Form::open(['method' => 'DELETE', 'route' => ['campaign_boosts.destroy', $boost->id]]) !!}
    <div class="pb-5">
        <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">
            {{ __('crud.cancel') }}
        </button>
        <button type="submit" class="btn btn-danger px-8 ml-5 rounded-full">
            <span class="">{{ __('settings/premium.remove.confirm') }}</span>
        </button>
    </div>
    {!! Form::close() !!}


</div>
