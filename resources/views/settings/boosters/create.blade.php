<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

{!! Form::open(['route' => ['campaign_boosts.store']]) !!}

@include('partials.forms.form', [
    'title' => __('settings/boosters.' . ($superboost ? 'superboost' : 'boost') . '.title', ['campaign' => $campaign->name]) ,
    'content' => 'settings.boosters.create._form',
    'actions' => 'settings.boosters.create._actions',
    'dialog' => true,
])
{!! Form::hidden('action', $superboost ? 'superboost' : 'boost') !!}
{!! Form::hidden('campaign_id', $campaign->id) !!}
{!! Form::close() !!}
