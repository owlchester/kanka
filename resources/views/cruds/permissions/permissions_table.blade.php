<?php
/**
 * @var \App\Services\PermissionService $permissionService
 * @var \App\Models\CampaignUser $member
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 */
use App\Models\CampaignPermission;
$actions = [
    'allow' => __('crud.permissions.actions.bulk_entity.allow'),
    'deny' => __('crud.permissions.actions.bulk_entity.deny'),
    'inherit' => __('crud.permissions.actions.bulk_entity.inherit'),
];
$permissionService->campaign($campaign);
?>

<x-helper>
    {!! __('crud.permissions.helpers.setup', [
        'allow' => '<code>' . __('crud.permissions.actions.bulk_entity.allow') . '</code>',
        'deny' => '<code>' . __('crud.permissions.actions.bulk_entity.deny') . '</code>',
        'inherit' => '<code>' . __('crud.permissions.actions.bulk_entity.inherit') . '</code>',
    ]) !!}
</x-helper>

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
            <x-icon class="question" tooltip :title="__('campaigns.roles.permissions.helpers.entity_note')" />
        </div>
    </div>
    @foreach ($campaign->roles()->withoutAdmin()->get() as $role)
        @php $permissionService->reset()->role($role) @endphp
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2 items-center">
            <div class="w-40 col-span-2 md:col-span-1">
                @can('update', $role)
                    <a href="{{ route('campaign_roles.edit', [$campaign, $role]) }}">
                        {{ $role->name }}
                    </a>
                    @if ($role->isPublic() && !$campaign->isPublic())
                        <x-icon class="fa-solid fa-exclamation-triangle" tooltip :title="__('campaigns.roles.permissions.helpers.not_public')" />
                    @endif
                @else
                    {{ $role->name }}
                @endcan
            </div>
            <div class="">
                <label class="inline md:hidden">{{ __('crud.permissions.actions.read') }}</label>
                <div class="join w-full field">
                    <x-forms.select
                        name="role[{{ $role->id }}][{{ CampaignPermission::ACTION_READ }}]"
                        :options="$actions"
                        :selected="$permissionService->action(CampaignPermission::ACTION_READ)->selected('role')"
                        class="join-item"
                        label="__('crud.permissions.actions.read')" />
                @if ($permissionService->inherited())
                    <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip" data-append="parent">
                                <x-icon class="text-green-500 fa-solid fa-check-circle" />
                    </span>
                @endif
                </div>
            </div>
            @if (!$role->isPublic())
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.edit') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="role[{{ $role->id }}][{{ CampaignPermission::ACTION_EDIT }}]"
                            :options="$actions"
                            :selected="$permissionService->action(CampaignPermission::ACTION_EDIT)->selected('role')"
                            class="join-item"
                            label="__('crud.permissions.actions.edit')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip" data-append="parent">
                                <x-icon class="text-green-500 fa-solid fa-check-circle" />
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.delete') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="role[{{ $role->id }}][{{ CampaignPermission::ACTION_DELETE }}]"
                            :options="$actions"
                            :selected="$permissionService->action(CampaignPermission::ACTION_DELETE)->selected('role')"
                            class="join-item"
                            label="__('crud.permissions.actions.delete')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip" data-append="parent">
                                <x-icon class="text-green-500 fa-solid fa-check-circle" />
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('entities.posts') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="role[{{ $role->id }}][{{ CampaignPermission::ACTION_POSTS }}]"
                            :options="$actions"
                            :selected="$permissionService->action(CampaignPermission::ACTION_POSTS)->selected('role')"
                            class="join-item"
                            label="__('entities.po')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip" data-append="parent">
                                <x-icon class="text-green-500 fa-solid fa-check-circle" />
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

    @if (isset($skipUsers) && $skipUsers && $campaign->nonAdmins()->count() > 10)
        <x-helper>{{ __('crud.permissions.too_many_members', ['number' => 10]) }}</x-helper>
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
                <x-icon class="question" tooltip :title="__('campaigns.roles.permissions.helpers.entity_note')" />
            </div>
        </div>
        @foreach ($campaign->nonAdmins() as $member)
            @php $permissionService->reset()->user($member->user) @endphp
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
                            <a class="btn2 btn-outline btn-xs btn-view-as" href="{{ route('identity.switch-entity', [$campaign, $member, $entity]) }}" data-title="{{ __('campaigns.members.helpers.switch') }}" data-toggle="tooltip">
                                <x-icon class="fa-solid fa-sign-in-alt" />
                                {{ __('campaigns.members.actions.switch-entity') }}
                            </a>
                        </div>
                    @endcan
                @endif
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.read') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="user[{{ $member->user_id }}][{{ CampaignPermission::ACTION_READ }}]"
                            :options="$actions"
                            :selected="$permissionService->action(CampaignPermission::ACTION_READ)->selected('user')"
                            class="join-item"
                            label="__('crud.permissions.actions.read')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName())
                           ]) }}" data-toggle="tooltip" data-append="parent">
                                <i class="text-{{ $permissionService->inheritedRoleAccess() ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.edit') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="user[{{ $member->user_id }}][{{ CampaignPermission::ACTION_EDIT }}]"
                            :options="$actions"
                            :selected="$permissionService->action(CampaignPermission::ACTION_EDIT)->selected('user')"
                            class="join-item"
                            label="__('crud.permissions.actions.edit')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName())
                           ]) }}" data-toggle="tooltip" data-append="parent">
                                <i class="text-{{ $permissionService->inheritedRoleAccess() ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.delete') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="user[{{ $member->user_id }}][{{ CampaignPermission::ACTION_DELETE }}]"
                            :options="$actions"
                            :selected="$permissionService->action(CampaignPermission::ACTION_DELETE)->selected('user')"
                            class="join-item"
                            label="__('crud.permissions.actions.delete')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName())
                           ]) }}" data-toggle="tooltip" data-append="parent">
                                <i class="text-{{ $permissionService->inheritedRoleAccess() ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('entities.posts') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="user[{{ $member->user_id }}][{{ CampaignPermission::ACTION_POSTS }}]"
                            :options="$actions"
                            :selected="$permissionService->action(CampaignPermission::ACTION_POSTS)->selected('user')"
                            class="join-item"
                            label="__('entities.posts')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName())
                           ]) }}" data-toggle="tooltip" data-append="parent">
                                <i class="text-{{ $permissionService->inheritedRoleAccess() ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
