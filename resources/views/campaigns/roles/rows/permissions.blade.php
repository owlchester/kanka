<?php
/** @var \App\Models\CampaignRole $model */
?>
<div class="flex gap-2 items-center">

@if (!$model->isAdmin())
    <a
        href="{{ route('campaign_roles.show', [$campaign, 'campaign_role' => $model]) }}"
        title="{{ __('campaigns.roles.actions.permissions') }}">
        {{ $model->permissions->whereNull('entity_id')->count() }}
    </a>
@endif

@if ($model->isPublic() && !$campaign->isPublic() && $model->permissions->whereNull('entity_id')->count() > 0)
    <div class="hidden sm:block">
        <x-icon class="fa-solid fa-exclamation-triangle" tooltip title="{{ __('campaigns.roles.hints.campaign_not_public') }}" />
    </div>
    <div class="sm:hidden">
        <span role="button" class="btn2 btn-xs">
            <i class="fa-solid fa-exclamation-triangle" data-animate="collapse" data-target="#campaign-public-warning"></i>
        </span>
        <span class="hidden help-block" id="campaign-public-warning">
            {{ __('campaigns.roles.hints.campaign_not_public') }}
        </span>
    </div>
@endif
</div>
