<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
?>

{!! Form::open(['method' => 'DELETE', 'route' => ['campaign_boosts.destroy', $boost->id]]) !!}
@include('partials.forms.form', [
    'title' => __('settings/premium.remove.title'),
    'content' => 'settings.premium.remove._form',
    'actions' => 'settings.premium.remove._actions',
    'dialog' => true,
])
{!! Form::close() !!}
