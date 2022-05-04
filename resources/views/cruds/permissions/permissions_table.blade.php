<?php
/**
 * @var \App\Services\PermissionService $permissionService
 * @var \App\Models\CampaignUser $member
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 */
$actions = [
    'allow' => __('crud.permissions.actions.bulk_entity.allow'),
    'deny' => __('crud.permissions.actions.bulk_entity.deny'),
    'inherit' => __('crud.permissions.actions.bulk_entity.inherit'),
];
$permissionService->campaign($campaign->campaign());
?>

<div id="crud_permissions">
    <div class="row margin-bottom">
        <div class="col-sm-4">
            <strong>{{ __('crud.permissions.fields.role') }}</strong>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa-solid fa-eye visible-xs visible-sm" title="{{ __('crud.permissions.actions.read') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.read') }}</strong></span>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa-solid fa-edit visible-xs visible-sm" title="{{ __('crud.permissions.actions.edit') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.edit') }}</strong></span>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa-solid fa-trash visible-xs visible-sm" title="{{ __('crud.permissions.actions.delete') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.delete') }}</strong></span>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa-solid fa-sticky-note visible-xs visible-sm" title="{{ __('crud.permissions.actions.entity_note') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.entity_note') }}</strong></span>
            <i class="fa-solid fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}"></i>
        </div>
    </div>
    @foreach ($campaign->campaign()->roles()->withoutAdmin()->get() as $role)
        <div class="row margin-bottom">
            <div class="col-sm-4">{{ $role->name }}</div>
            <div class="text-center col-sm-2">
                <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.read') }}</span>
                {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_READ . "]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_READ)) !!}
                @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_READ, $role->id))
                    <i class="text-green fa-solid fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                @endif
            </div>
            @if (!$role->is_public)
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.edit') }}</span>
                    {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_EDIT . "]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_EDIT)) !!}
                    @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_EDIT, $role->id))
                        <i class="text-green fa-solid fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.delete') }}</span>
                    {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_DELETE ."]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_DELETE)) !!}
                    @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_DELETE, $role->id))
                        <i class="text-green fa-solid fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.entity_note') }}</span>
                    {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_POSTS . "]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_POSTS)) !!}
                    @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_POSTS, $role->id))
                        <i class="text-green fa-solid fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                    @endif
                </div>
            @endif
        </div>
    @endforeach

    @if (isset($skipUsers) && $skipUsers && $permissionService->users()->count() > 10)
        <p class="help-block">{{ __('crud.permissions.too_many_members', ['number' => 10]) }}</p>
        <input type="hidden" name="permissions_too_many" value="1" />
    @else
        <div class="row margin-bottom">
            <div class="col-sm-12">
                <hr />
            </div>
        </div>
        <div class="row margin-bottom">
            <div class="col-sm-4"><strong>{{ __('crud.permissions.fields.member') }}</strong></div>

            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa-solid fa-eye visible-xs visible-sm" title="{{ __('crud.permissions.actions.read') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.read') }}</strong></span>
            </div>
            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa-solid fa-edit visible-xs visible-sm" title="{{ __('crud.permissions.actions.edit') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.edit') }}</strong></span>
            </div>
            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa-solid fa-trash visible-xs visible-sm" title="{{ __('crud.permissions.actions.delete') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.delete') }}</strong></span>
            </div>
            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa-solid fa-sticky-note visible-xs visible-sm" title="{{ __('crud.permissions.actions.entity_note') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.entity_note') }}</strong></span>
                <i class="fa-solid fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}"></i>
            </div>
        </div>
        @foreach ($permissionService->users() as $member)
            <div class="row margin-bottom">
                <div class="col-sm-4">
                    <div class="entity-image pull-left" style="background-image: url({{ $member->user->getAvatarUrl() }})" title="{{ $member->user->name }}">
                    </div>
                    <div class="user-name">{{ $member->user->name }}</div>
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.read') }}</span>
                    {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_READ ."]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_READ)) !!}
                    @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_READ, 0, $member->user_id))
                        <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_READ, $member->user_id) ? 'green' : 'red' }} fa-solid fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                       'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_READ, $member->user_id))
                   ]) }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.edit') }}</span>
                    {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_EDIT . "]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_EDIT)) !!}
                    @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_EDIT, 0, $member->user_id))
                        <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_EDIT, $member->user_id) ? 'green' : 'red' }} fa-solid fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                       'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_EDIT, $member->user_id))
                   ]) }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.delete') }}</span>
                    {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_DELETE . "]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_DELETE)) !!}
                    @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_DELETE, 0, $member->user_id))
                        <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_DELETE, $member->user_id) ? 'green' : 'red' }} fa-solid fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                       'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_DELETE, $member->user_id))
                   ]) }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.entity_note') }}</span>
                    {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_POSTS . "]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_POSTS)) !!}
                    @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_POSTS, 0, $member->user_id))
                        <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_POSTS, $member->user_id) ? 'green' : 'red' }} fa-solid fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                       'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_POSTS, $member->user_id))
                   ]) }}" data-toggle="tooltip"></i>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
