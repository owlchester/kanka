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
$permissionService->campaign($campaignService->campaign());
?>

<p class="help-block">
    {!! __('crud.permissions.helpers.setup', [
        'allow' => '<code>' . __('crud.permissions.actions.bulk_entity.allow') . '</code>',
        'deny' => '<code>' . __('crud.permissions.actions.bulk_entity.deny') . '</code>',
        'inherit' => '<code>' . __('crud.permissions.actions.bulk_entity.inherit') . '</code>',
    ]) !!}
</p>

<div id="crud_permissions">
    <div class="row mb-5">
        <div class="col-sm-4">
            <strong>{{ __('crud.permissions.fields.role') }}</strong>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa-solid fa-eye visible-xs visible-sm" aria-hidden="true" title="{{ __('crud.permissions.actions.read') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.read') }}</strong></span>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa-solid fa-edit visible-xs visible-sm" aria-hidden="true" title="{{ __('crud.permissions.actions.edit') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.edit') }}</strong></span>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa-solid fa-trash visible-xs visible-sm" aria-hidden="true" title="{{ __('crud.permissions.actions.delete') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.delete') }}</strong></span>
        </div>
        <div class="col-sm-2 hidden-xs hidden-xm text-center">
            <i class="fa-solid fa-sticky-note visible-xs visible-sm" aria-hidden="true" title="{{ __('entities.posts') }}"></i>
            <span class="hidden-xs hidden-sm"><strong>{{ __('entities.posts') }}</strong></span>
            <i class="fa-solid fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}"></i>
        </div>
    </div>
    @foreach ($campaignService->campaign()->roles()->withoutAdmin()->get() as $role)
        <div class="row mb-5">
            <div class="col-sm-4">{{ $role->name }}</div>
            <div class="text-center col-sm-2">
                <div class="input-group w-full">
                    <label class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.read') }}</label>
                    {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_READ . "]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_READ), [
                        'class' => 'form-control',
                        'aria-label' => __('crud.permissions.actions.read'),
                    ]) !!}
                    @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_READ, $role->id))
                        <span class="" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip">
                            <i class="text-green-500 fa-solid fa-check-circle" aria-hidden="true"></i>
                        </span>
                    @endif
                </div>
            </div>
            @if (!$role->is_public)
                <div class="col-sm-2 text-center">
                    <div class="input-group w-full">
                        <label class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.edit') }}</label>
                        {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_EDIT . "]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_EDIT), [
                                'class' => 'form-control',
                                'aria-label' => __('crud.permissions.actions.edit'),
                            ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_EDIT, $role->id))
                            <span class="" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip">
                                <i class="text-green-500 fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2 text-center">
                    <div class="input-group w-full">
                        <label class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.delete') }}</label>
                        {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_DELETE ."]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_DELETE), [
                            'class' => 'form-control',
                            'aria-label' => __('crud.permissions.actions.delete'),
                        ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_DELETE, $role->id))
                            <span class="" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip">
                                <i class="text-green-500 fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2 text-center">
                    <div class="input-group w-full">
                        <label class="visible-xs-inline visible-sm-inline">{{ __('entities.posts') }}</label>
                        {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_POSTS . "]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_POSTS), [
                                'class' => 'form-control',
                                'aria-label' => __('entities.posts'),
                            ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_POSTS, $role->id))
                            <span class="" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip">
                                <i class="text-green-500 fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endforeach

    @if (isset($skipUsers) && $skipUsers && $permissionService->users()->count() > 10)
        <p class="help-block">{{ __('crud.permissions.too_many_members', ['number' => 10]) }}</p>
        <input type="hidden" name="permissions_too_many" value="1" />
    @else
        <div class="row mb-5">
            <div class="col-sm-12">
                <hr />
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-sm-4"><strong>{{ __('crud.permissions.fields.member') }}</strong></div>

            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa-solid fa-eye visible-xs visible-sm" aria-hidden="true" title="{{ __('crud.permissions.actions.read') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.read') }}</strong></span>
            </div>
            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa-solid fa-edit visible-xs visible-sm" aria-hidden="true" title="{{ __('crud.permissions.actions.edit') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.edit') }}</strong></span>
            </div>
            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa-solid fa-trash visible-xs visible-sm" aria-hidden="true" title="{{ __('crud.permissions.actions.delete') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('crud.permissions.actions.delete') }}</strong></span>
            </div>
            <div class="col-sm-2 hidden-xs hidden-xm text-center">
                <i class="fa-solid fa-sticky-note visible-xs visible-sm" aria-hidden="true" title="{{ __('entities.posts') }}"></i>
                <span class="hidden-xs hidden-sm"><strong>{{ __('entities.posts') }}</strong></span>
                <i class="fa-solid fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}"></i>
            </div>
        </div>
        @foreach ($permissionService->users() as $member)
            <div class="row mb-5">
                <div class="col-sm-4">
                    <div class="flex items-center gap-2">
                        <div class="flex-none">
                            <div class="entity-image cover-background" style="background-image: url({{ $member->user->getAvatarUrl() }})" title="{{ $member->user->name }}">
                            </div>
                        </div>
                        <div class="flex-grow truncate">
                            {{ $member->user->name }}
                        </div>
                    @if (isset($entity))
                        @can('switch', $member)
                            <div class="flex-none">
                                <a class="btn2 btn-outline btn-accent btn-xs btn-view-as" href="{{ route('identity.switch-entity', [$member, $entity]) }}" title="{{ __('campaigns.members.helpers.switch') }}" data-toggle="tooltip">
                                    <i class="fa-solid fa-sign-in-alt" aria-hidden="true"></i>
                                    {{ __('campaigns.members.actions.switch-entity') }}
                                </a>
                            </div>
                        @endcan
                    @endif
                    </div>
                </div>
                <div class="col-sm-2 text-center">
                    <div class="input-group w-full">
                        <label class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.read') }}</label>
                        {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_READ ."]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_READ), [
                            'class' => 'form-control',
                            'aria-label' => __('crud.permissions.actions.read'),
                        ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_READ, 0, $member->user_id))
                            <span class="" title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_READ, $member->user_id))
                           ]) }}" data-toggle="tooltip">
                                <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_READ, $member->user_id) ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2 text-center">
                    <div class="input-group w-full">
                        <label class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.edit') }}</label>
                        {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_EDIT . "]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_EDIT), [
                                'class' => 'form-control',
                                'aria-label' => __('crud.permissions.actions.edit'),
                            ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_EDIT, 0, $member->user_id))
                            <span class="" title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_EDIT, $member->user_id))
                           ]) }}" data-toggle="tooltip">
                                <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_EDIT, $member->user_id) ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2 text-center">
                    <div class="input-group w-full">
                        <label class="visible-xs-inline visible-sm-inline">{{ __('crud.permissions.actions.delete') }}</label>
                        {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_DELETE . "]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_DELETE), [
                                'class' => 'form-control',
                                'aria-label' => __('crud.permissions.actions.delete'),
                        ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_DELETE, 0, $member->user_id))
                            <span class="" title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_DELETE, $member->user_id))
                           ]) }}" data-toggle="tooltip">
                                <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_DELETE, $member->user_id) ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2 text-center">
                    <div class="input-group w-full">
                    <label class="visible-xs-inline visible-sm-inline">{{ __('entities.posts') }}</label>
                        {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_POSTS . "]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_POSTS), [
                                'class' => 'form-control',
                                'aria-label' => __('entities.posts'),
                            ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_POSTS, 0, $member->user_id))
                            <span class="" title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_POSTS, $member->user_id))
                           ]) }}" data-toggle="tooltip">
                                <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_POSTS, $member->user_id) ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
