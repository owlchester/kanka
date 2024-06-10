<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>
<x-form :action="['campaign_boosts.store']">

    @include('partials.forms.form', [
        'title' => __('settings/boosters.' . ($superboost ? 'superboost' : 'boost') . '.title', ['campaign' => $campaign->name]) ,
        'content' => 'settings.boosters.create._form',
        'actions' => 'settings.boosters.create._actions',
        'dialog' => true,
    ])
    <input type="hidden" name="action" value="{{ $superboost ? 'superboost' : 'boost' }}" />
    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}" />
</x-form>
