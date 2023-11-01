<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

{!! Form::open(['route' => ['campaign_boosts.store']]) !!}
    @include('partials.forms.form', [
        'title' => __('settings/premium.actions.unlock'),
        'content' => 'settings.premium.create._form',
        'actions' => 'settings.premium.create._actions',
        'dialog' => true,
    ])

{!! Form::hidden('campaign_id', $campaign->id) !!}
{!! Form::close() !!}
