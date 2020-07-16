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
?>


<div id="crud_permissions" class="tooltip-wide">
    <div class="row margin-bottom">
        <div class="col-sm-4">
            <strong>{{ __('crud.permissions.fields.role') }}</strong>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa fa-eye visible-xs visible-sm" title="{{ __('crud.permissions.actions.read') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.read') }}</strong></span>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa fa-edit visible-xs visible-sm" title="{{ __('crud.permissions.actions.edit') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.edit') }}</strong></span>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa fa-trash visible-xs visible-sm" title="{{ __('crud.permissions.actions.delete') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.delete') }}</strong></span>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa fa-sticky-note visible-xs visible-sm" title="{{ __('crud.permissions.actions.entity_note') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.entity_note') }}</strong></span>
            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}"></i>
        </div>
    </div>
    @foreach ($campaign->campaign()->roles()->withoutAdmin()->get() as $role)
        <div class="row margin-bottom">
            <div class="col-sm-4">{{ $role->name }}</div>
            <div class="text-center col-sm-2">
                <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.read') }}</span>
                {!! Form::select("role[$role->id][read]", $actions, $permissionService->selected('role', $role->id, 'read')) !!}
                @if ($permissionService->inherited('read', $role->id))
                    <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                @endif
            </div>
            @if (!$role->is_public)
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.edit') }}</span>
                    {!! Form::select("role[$role->id][edit]", $actions, $permissionService->selected('role', $role->id, 'edit')) !!}
                    @if ($permissionService->inherited('edit', $role->id))
                        <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.delete') }}</span>
                    {!! Form::select("role[$role->id][delete]", $actions, $permissionService->selected('role', $role->id, 'delete')) !!}
                    @if ($permissionService->inherited('delete', $role->id))
                        <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.entity_note') }}</span>
                    {!! Form::select("role[$role->id][entity-note]", $actions, $permissionService->selected('role', $role->id, 'entity-note')) !!}
                    @if ($permissionService->inherited('entity-note', $role->id))
                        <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                    @endif
                </div>
            @endif
        </div>
    @endforeach

    @if (isset($skipUsers) && $skipUsers && $campaign->campaign()->members->count() > 10)
        <p class="help-block">{{ __('crud.permissions.too_many_members') }}</p>
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
                <i class="fa fa-eye visible-xs visible-sm" title="{{ __('crud.permissions.actions.read') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.read') }}</strong></span>
            </div>
            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa fa-edit visible-xs visible-sm" title="{{ __('crud.permissions.actions.edit') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.edit') }}</strong></span>
            </div>
            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa fa-trash visible-xs visible-sm" title="{{ __('crud.permissions.actions.delete') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.delete') }}</strong></span>
            </div>
            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa fa-sticky-note visible-xs visible-sm" title="{{ __('crud.permissions.actions.entity_note') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.entity_note') }}</strong></span>
                <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}"></i>
            </div>
        </div>
        @foreach ($campaign->campaign()->members()->withoutAdmins()->with('user')->get() as $member)
            <div class="row margin-bottom">
                <div class="col-sm-4">
                    <div class="entity-image float-left" style="background-image: url({{ $member->user->getAvatarUrl() }})" title="{{ $member->user->name }}">
                    </div>
                    <div class="entity-name-img">{{ $member->user->name }}</div>
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.read') }}</span>
                    {!! Form::select("user[$member->user_id][read]", $actions, $permissionService->selected('user', $member->user_id, 'read')) !!}
                    @if ($permissionService->inherited('read', 0, $member->user_id))
                        <i class="text-{{ $permissionService->inheritedRoleAccess('read', $member->user_id) ? 'green' : 'red' }} fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                       'role' => e($permissionService->inheritedRoleName('read', $member->user_id))
                   ]) }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.edit') }}</span>
                    {!! Form::select("user[$member->user_id][edit]", $actions, $permissionService->selected('user', $member->user_id, 'edit')) !!}
                    @if ($permissionService->inherited('edit', 0, $member->user_id))
                        <i class="text-{{ $permissionService->inheritedRoleAccess('edit', $member->user_id) ? 'green' : 'red' }} fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                       'role' => e($permissionService->inheritedRoleName('edit', $member->user_id))
                   ]) }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.delete') }}</span>
                    {!! Form::select("user[$member->user_id][delete]", $actions, $permissionService->selected('user', $member->user_id, 'delete')) !!}
                    @if ($permissionService->inherited('delete', 0, $member->user_id))
                        <i class="text-{{ $permissionService->inheritedRoleAccess('delete', $member->user_id) ? 'green' : 'red' }} fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                       'role' => e($permissionService->inheritedRoleName('delete', $member->user_id))
                   ]) }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                <div class="col-sm-2 text-center">
                    <span class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.entity_note') }}</span>
                    {!! Form::select("user[$member->user_id][entity-note]", $actions, $permissionService->selected('user', $member->user_id, 'entity-note')) !!}
                    @if ($permissionService->inherited('entity-note', 0, $member->user_id))
                        <i class="text-{{ $permissionService->inheritedRoleAccess('entity-note', $member->user_id) ? 'green' : 'red' }} fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                       'role' => e($permissionService->inheritedRoleName('entity-note', $member->user_id))
                   ]) }}" data-toggle="tooltip"></i>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
