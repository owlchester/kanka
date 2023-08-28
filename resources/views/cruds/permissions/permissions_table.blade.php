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
$permissionService->campaign($campaign);
?>

<p class="help-block">
    {!! __('crud.permissions.helpers.setup', [
        'allow' => '<code>' . __('crud.permissions.actions.bulk_entity.allow') . '</code>',
        'deny' => '<code>' . __('crud.permissions.actions.bulk_entity.deny') . '</code>',
        'inherit' => '<code>' . __('crud.permissions.actions.bulk_entity.inherit') . '</code>',
    ]) !!}
</p>

<div id="crud_permissions" class="flex flex-col gap-3">
    <div class="hidden md:grid md:grid-cols-5 gap-2">
        <div class="w-40 ">
            <strong>{{ __('crud.permissions.fields.role') }}</strong>
        </div>
        <div class="">
            <i class="fa-solid fa-eye md:hidden" aria-hidden="true" title="{{ __('crud.permissions.actions.read') }}"></i>
            <span class="hidden md:inline"><strong>{{ __('crud.permissions.actions.read') }}</strong></span>
        </div>
        <div class="">
            <i class="fa-solid fa-edit md:hidden" aria-hidden="true" title="{{ __('crud.permissions.actions.edit') }}"></i>
            <span class="hidden md:inline"><strong>{{ __('crud.permissions.actions.edit') }}</strong></span>
        </div>
        <div class="">
            <i class="fa-solid fa-trash md:hidden" aria-hidden="true" title="{{ __('crud.permissions.actions.delete') }}"></i>
            <span class="hidden md:inline"><strong>{{ __('crud.permissions.actions.delete') }}</strong></span>
        </div>
        <div class="">
            <i class="fa-solid fa-sticky-note md:hidden" aria-hidden="true" title="{{ __('entities.posts') }}"></i>
            <span class="hidden md:inline"><strong>{{ __('entities.posts') }}</strong></span>
            <x-icon class="question" :tooltip="true" :title="__('campaigns.roles.permissions.helpers.entity_note')"></x-icon>
        </div>
    </div>
    @foreach ($campaign->roles()->withoutAdmin()->get() as $role)
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 items-center">
            <div class="w-40 col-span-2 md:col-span-1  ">{{ $role->name }}</div>
            <div class="">
                <label class="inline md:hidden">{{ __('crud.permissions.actions.read') }}</label>
                <div class="join w-full field">
                {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_READ . "]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_READ), [
                    'class' => 'form-control join-item w-full',
                    'aria-label' => __('crud.permissions.actions.read'),
                ]) !!}
                @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_READ, $role->id))
                    <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip">
                        <i class="text-green-500 fa-solid fa-check-circle" aria-hidden="true"></i>
                    </span>
                @endif
                </div>
            </div>
            @if (!$role->isPublic())
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.edit') }}</label>
                    <div class="join w-full field">
                        {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_EDIT . "]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_EDIT), [
                                'class' => 'join-item w-full',
                                'aria-label' => __('crud.permissions.actions.edit'),
                            ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_EDIT, $role->id))
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip">
                                <i class="text-green-500 fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.delete') }}</label>
                    <div class="join w-full field">
                        {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_DELETE ."]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_DELETE), [
                            'class' => ' w-full join-item',
                            'aria-label' => __('crud.permissions.actions.delete'),
                        ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_DELETE, $role->id))
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip">
                                <i class="text-green-500 fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('entities.posts') }}</label>
                    <div class="join w-full field">
                        {!! Form::select("role[$role->id][" . \App\Models\CampaignPermission::ACTION_POSTS . "]", $actions, $permissionService->selected('role', $role->id, \App\Models\CampaignPermission::ACTION_POSTS), [
                                'class' => ' w-full join-item',
                                'aria-label' => __('entities.posts'),
                            ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_POSTS, $role->id))
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip">
                                <i class="text-green-500 fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @else
                <div></div>
                <div></div>
                <div></div>
            @endif
        </div>
    @endforeach

    @if (isset($skipUsers) && $skipUsers && $permissionService->users()->count() > 10)
        <p class="help-block">{{ __('crud.permissions.too_many_members', ['number' => 10]) }}</p>
        <input type="hidden" name="permissions_too_many" value="1" />
    @else
        <hr />

        <div class="hidden md:grid grid-cols-5 gap-2 justify-center">
            <div class=""><strong>{{ __('crud.permissions.fields.member') }}</strong></div>

            <div class="">
                <i class="fa-solid fa-eye md:hidden" aria-hidden="true" title="{{ __('crud.permissions.actions.read') }}"></i>
                <span class="hidden md:inline"><strong>{{ __('crud.permissions.actions.read') }}</strong></span>
            </div>
            <div class="">
                <i class="fa-solid fa-edit md:hidden" aria-hidden="true" title="{{ __('crud.permissions.actions.edit') }}"></i>
                <span class="hidden md:inline"><strong>{{ __('crud.permissions.actions.edit') }}</strong></span>
            </div>
            <div class="">
                <i class="fa-solid fa-trash md:hidden" aria-hidden="true" title="{{ __('crud.permissions.actions.delete') }}"></i>
                <span class="hidden md:inline"><strong>{{ __('crud.permissions.actions.delete') }}</strong></span>
            </div>
            <div class="">
                <i class="fa-solid fa-sticky-note md:hidden" aria-hidden="true" title="{{ __('entities.posts') }}"></i>
                <span class="hidden md:inline"><strong>{{ __('entities.posts') }}</strong></span>
                <x-icon class="question" :tooltip="true" :title="__('campaigns.roles.permissions.helpers.entity_note')"></x-icon>
            </div>
        </div>
        @foreach ($permissionService->users() as $member)
            <div class="grid grid-cols-2 md:grid-cols-5 md: gap-2">
                <div class="col-span-2 md:col-span-1 flex flex-wrap items-center gap-2">
                    <div class="flex-none">
                        <div class="entity-image cover-background" style="background-image: url({{ $member->user->getAvatarUrl() }})" title="{{ $member->user->name }}">
                        </div>
                    </div>
                    <div class="truncate">
                        {{ $member->user->name }}
                    </div>
                @if (isset($entity))
                    @can('switch', $member)
                        <div class="grow">
                            <a class="btn2 btn-outline btn-accent btn-xs btn-view-as" href="{{ route('identity.switch-entity', [$campaign, $member, $entity]) }}" data-title="{{ __('campaigns.members.helpers.switch') }}" data-toggle="tooltip">
                                <i class="fa-solid fa-sign-in-alt" aria-hidden="true"></i>
                                {{ __('campaigns.members.actions.switch-entity') }}
                            </a>
                        </div>
                    @endcan
                @endif
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.read') }}</label>
                    <div class="join w-full field">
                        {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_READ ."]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_READ), [
                            'class' => ' w-full join-item',
                            'aria-label' => __('crud.permissions.actions.read'),
                        ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_READ, 0, $member->user_id))
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_READ, $member->user_id))
                           ]) }}" data-toggle="tooltip">
                                <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_READ, $member->user_id) ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.edit') }}</label>
                    <div class="join w-full field">
                        {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_EDIT . "]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_EDIT), [
                                'class' => ' w-full join-item',
                                'aria-label' => __('crud.permissions.actions.edit'),
                            ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_EDIT, 0, $member->user_id))
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_EDIT, $member->user_id))
                           ]) }}" data-toggle="tooltip">
                                <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_EDIT, $member->user_id) ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.delete') }}</label>
                    <div class="join w-full field">
                        {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_DELETE . "]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_DELETE), [
                                'class' => ' w-full join-item',
                                'aria-label' => __('crud.permissions.actions.delete'),
                        ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_DELETE, 0, $member->user_id))
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName(\App\Models\CampaignPermission::ACTION_DELETE, $member->user_id))
                           ]) }}" data-toggle="tooltip">
                                <i class="text-{{ $permissionService->inheritedRoleAccess(\App\Models\CampaignPermission::ACTION_DELETE, $member->user_id) ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('entities.posts') }}</label>
                    <div class="join w-full field">
                        {!! Form::select("user[$member->user_id][" . \App\Models\CampaignPermission::ACTION_POSTS . "]", $actions, $permissionService->selected('user', $member->user_id, \App\Models\CampaignPermission::ACTION_POSTS), [
                                'class' => ' w-full join-item',
                                'aria-label' => __('entities.posts'),
                            ]) !!}
                        @if ($permissionService->inherited(\App\Models\CampaignPermission::ACTION_POSTS, 0, $member->user_id))
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited_by', [
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
