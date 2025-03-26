<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>
<x-form :action="['campaign_boosts.store']">
    @include('partials.forms._dialog', [
        'title' => __('settings/premium.actions.unlock'),
        'content' => 'settings.premium.create._form',
        'actions' => 'settings.premium.create._actions',
    ])

    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}" />
</x-form>
