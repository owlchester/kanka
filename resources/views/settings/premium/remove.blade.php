<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<div class="modal-body text-center">
    <x-dialog.close :modal="true" />

    <h4 class="mt-0">
        {{ __('settings/premium.remove.title') }}
    </h4>
    @if($boost->inCooldown())
        <p class="py-5">{!! __('settings/premium.remove.cooldown', [
        'campaign' => '<strong>' . $campaign->name . '</strong>', 'date' => $boost->created_at->addDays(7)->diffForHumans()])!!}</p>
    @else
        <p class="py-5">{!! __('settings/premium.remove.warning', [
        'campaign' => '<strong>' . $campaign->name . '</strong>'])!!}</p>

        {!! Form::open(['method' => 'DELETE', 'route' => ['campaign_boosts.destroy', $boost->id]]) !!}

        <x-dialog.footer :modal="true">
            <button type="submit" class="btn2 btn-error">
                <span class="">{{ __('settings/premium.remove.confirm') }}</span>
            </button>
        </x-dialog.footer>
        {!! Form::close() !!}
    @endif

</div>
