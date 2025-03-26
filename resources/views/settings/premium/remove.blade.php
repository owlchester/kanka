<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<x-form method="DELETE" :action="['campaign_boosts.destroy', $boost->id]">
@include('partials.forms._dialog', [
    'title' => __('settings/premium.remove.title'),
    'content' => 'settings.premium.remove._form',
    'actions' => 'settings.premium.remove._actions',
])
</x-form>
