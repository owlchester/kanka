<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

<x-form method="DELETE" :action="['campaign_boosts.destroy', $boost->id]">
@include('partials.forms._dialog', [
  'title' => __('settings/boosters.unboost.title'),
  'content' => 'settings.boosters.unboost._form',
  'actions' => 'settings.boosters.unboost._actions',
])
</x-form>

