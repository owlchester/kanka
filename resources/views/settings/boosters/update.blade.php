<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

{!! Form::model($boost, ['route' => ['campaign_boosts.update', $boost], 'method' => 'PATCH']) !!}
@include('partials.forms.form', [
    'title' => __('settings/boosters.superboost.title', ['campaign' => $campaign->name]),
    'content' => 'settings.boosters.update._form',
    'actions' => 'settings.boosters.update._actions',
    'dialog' => true,
])
<input type="hidden" name="action" value="superboost" />
<input type="hidden" name="campaign_id" value="{{ $campaign->id }}" />
{!! Form::close() !!}

