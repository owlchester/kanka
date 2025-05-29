<?php
/** @var \App\Models\CampaignRole $model */
?>
<div class="flex gap-2 items-center">

@if (!$model->isAdmin())
    <a
        href="{{ route('campaign_roles.show', [$campaign, 'campaign_role' => $model]) }}"
        title="{{ __('campaigns.roles.actions.permissions') }}">
        {{ number_format($model->role_permissions_count) }}
    </a>
@endif

@if ($model->isPublic() && !$campaign->isPublic() && $model->role_permissions_count > 0)
    <div class="hidden sm:block">
        <x-icon class="fa-solid fa-exclamation-triangle" tooltip title="{{ __('campaigns.roles.hints.campaign_not_public') }}" />
    </div>
    <div class="sm:hidden cursor-pointer" x-data="{open: false}" @click="open = !open">
        <span role="button" class="btn2 btn-xs" >
            <i class="fa-solid fa-exclamation-triangle"></i>
        </span>
        <span x-show="open" class="help-block text-xs">
            {{ __('campaigns.roles.hints.campaign_not_public') }}
        </span>
    </div>
@endif
</div>
