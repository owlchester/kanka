<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>
<x-form :action="['campaign_boosts.store']">

    <div class="flex flex-col gap-5 rounded p-4 shadow-sm">
        @include('settings.boosters.create._form')
        <div class="flex gap-5 justify-end">
            @include('settings.boosters.create._actions')
        </div>
    </div>
    <input type="hidden" name="action" value="{{ $superboost ? 'superboost' : 'boost' }}" />
    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}" />
</x-form>
