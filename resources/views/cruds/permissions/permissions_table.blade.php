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
$hasActionCol = isset($showPermissionActions) && auth()->user()->isAdmin();
$cols = 'md:grid-cols-5';
if ($hasActionCol) {
    $cols = 'md:grid-cols-6';
}
$moduleName = isset($entityType) ? $entityType->name() : $entity->entityType->name();
?>

<x-helper>
    <p>{!! __('crud.permissions.helpers.setup', [
        'allow' => '<code>' . __('crud.permissions.actions.bulk_entity.allow') . '</code>',
        'deny' => '<code>' . __('crud.permissions.actions.bulk_entity.deny') . '</code>',
        'inherit' => '<code>' . __('crud.permissions.actions.bulk_entity.inherit') . '</code>',
    ]) !!}</p>
</x-helper>

<div id="crud_permissions" class="flex flex-col gap-2">
    <div class="hidden md:grid {{ $cols }} gap-2">
        <div class="w-40 ">
            <span class="font-bold">{{ __('crud.permissions.fields.role') }}</span>
        </div>
        <div class="" data-title="{{ __('permissions.helpers.view') }}" data-tooltip>
            <span class="hidden md:inline font-bold">{{ __('crud.permissions.actions.view') }}</span>
            <x-icon class="fa-regular fa-eye md:hidden" />
        </div>
        <div class="" data-title="{{ __('permissions.helpers.edit') }}" data-tooltip>
            <span class="hidden md:inline font-bold">{{ __('crud.permissions.actions.edit') }}</span>
            <x-icon class="fa-regular fa-edit md:hidden" />
        </div>
        <div class="" data-title="{{ __('permissions.helpers.delete') }}" data-tooltip>
            <span class="hidden md:inline font-bold">{{ __('crud.permissions.actions.delete') }}</span>
            <x-icon class="fa-regular fa-trash-can md:hidden" />
        </div>
        <div class="" data-title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}" data-tooltip>
            <span class="hidden md:inline font-bold">{{ __('entities.posts') }}</span>
            <x-icon class="fa-regular fa-note-sticky md:hidden" />
        </div>
        @if ($hasActionCol)
            <div class="">
                <span class="hidden md:inline font-bold">{{ __('crud.actions.actions') }}</span>
            </div>
        @endif
    </div>
    @foreach ($campaign->roles()->withoutAdmin()->get() as $role)
        @php $permissionService->reset()->role($role) @endphp
        <div class="grid grid-cols-2 {{ $cols }} gap-2 items-center">
            <div class="w-40 col-span-2 md:col-span-1">
                @can('update', $role)
                    <a href="{{ route('campaign_roles.show', [$campaign, $role]) }}">
                        {!! $role->name !!}
                    </a>
                    @if ($role->isPublic() && !$campaign->isPublic())
                        <x-icon class="fa-regular fa-exclamation-triangle" tooltip :title="__('campaigns.roles.permissions.helpers.not_public')" />
                    @endif
                @else
                    {!! $role->name !!}
                @endcan
            </div>
            <div class="">
                <label class="inline md:hidden">{{ __('crud.permissions.actions.view') }}</label>
                <div class="join w-full field">
                    <x-forms.select
                        name="role[{{ $role->id }}][{{ \App\Enums\Permission::View->value }}]"
                        :options="$actions"
                        :selected="$permissionService->action(\App\Enums\Permission::View)->selected('role')"
                        class="join-item permission-control"
                        :label="__('permissions.helpers.view')" />
                @if ($permissionService->inherited())
                    <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('permissions.roles.inherited', ['role' => $role->name, 'module' => $moduleName]) }}" data-toggle="tooltip" data-append="parent">
                            <x-icon class="text-green-500 fa-solid fa-check-circle" />
                    </span>
                    <span class="sr-only">{{ __('permissions.roles.inherited', ['role' => $role->name, 'module' => $moduleName]) }}</span>
                @endif
                </div>
            </div>
            @if (!$role->isPublic())
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.edit') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="role[{{ $role->id }}][{{ \App\Enums\Permission::Update->value }}]"
                            :options="$actions"
                            :selected="$permissionService->action(\App\Enums\Permission::Update)->selected('role')"
                            class="join-item permission-control"
                            :label="__('permissions.helpers.edit')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('permissions.roles.inherited', ['role' => $role->name, 'module' => $moduleName]) }}" data-toggle="tooltip" data-append="parent">
                                <x-icon class="text-green-500 fa-solid fa-check-circle" />
                            </span>
                            <span class="sr-only">{{ __('permissions.roles.inherited', ['role' => $role->name, 'module' => $moduleName]) }}</span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.delete') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="role[{{ $role->id }}][{{ \App\Enums\Permission::Delete->value }}]"
                            :options="$actions"
                            :selected="$permissionService->action(\App\Enums\Permission::Delete)->selected('role')"
                            class="join-item permission-control"
                            :label="__('permissions.helpers.delete')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('permissions.roles.inherited', ['role' => $role->name, 'module' => $moduleName]) }}" data-toggle="tooltip" data-append="parent">
                                <x-icon class="text-green-500 fa-solid fa-check-circle" />
                            </span>
                            <span class="sr-only">{{ __('permissions.roles.inherited', ['role' => $role->name, 'module' => $moduleName]) }}</span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('entities.posts') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="role[{{ $role->id }}][{{ \App\Enums\Permission::Posts->value }}]"
                            :options="$actions"
                            :selected="$permissionService->action(\App\Enums\Permission::Posts)->selected('role')"
                            class="join-item permission-control"
                            :label="__('entities.posts')" />
                        @if ($permissionService->inherited())
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ __('permissions.roles.inherited', ['role' => $role->name, 'module' => $moduleName]) }}" data-toggle="tooltip" data-append="parent">
                                <x-icon class="text-green-500 fa-solid fa-check-circle" />
                            </span>
                            <span class="sr-only">{{ __('permissions.roles.inherited', ['role' => $role->name, 'module' => $moduleName]) }}</span>
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

    @if (isset($skipUsers) && $skipUsers && $campaign->nonAdmins()->count() > config('limits.campaigns.members'))
        <x-helper>
            <p>{{ __('crud.permissions.too_many_members', ['number' => config('limits.campaigns.members')]) }}</p>
        </x-helper>
        <input type="hidden" name="permissions_too_many" value="1" />
    @else

        <div class="hidden md:grid {{ $cols }} gap-2 justify-center mt-5">
            <div class="font-bold">{{ __('crud.permissions.fields.member') }}</div>

            <div class="" data-title="{{ __('permissions.helpers.view') }}" data-tooltip>
                <span class="hidden md:inline font-bold">{{ __('crud.permissions.actions.view') }}</span>
                <x-icon class="fa-regular fa-eye md:hidden" />
            </div>
            <div class="" data-title="{{ __('permissions.helpers.edit') }}" data-tooltip>
                <span class="hidden md:inline font-bold">{{ __('crud.permissions.actions.edit') }}</span>
                <x-icon class="fa-regular fa-edit md:hidden" />
            </div>
            <div class="" data-title="{{ __('permissions.helpers.delete') }}" data-tooltip>
                <span class="hidden md:inline font-bold">{{ __('crud.permissions.actions.delete') }}</span>
                <x-icon class="fa-regular fa-trash-can md:hidden"  />
            </div>
            <div class="" data-title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}" data-tooltip>
                <span class="hidden md:inline font-bold">{{ __('entities.posts') }}</span>
                <x-icon class="fa-regular fa-sticky-note md:hidden" />
            </div>
            @if ($hasActionCol)
                <div class="">
                    <span class="hidden md:inline font-bold">{{ __('crud.actions.actions') }}</span>
                </div>
            @endif
        </div>
        @foreach ($campaign->nonAdmins() as $member)
            @php
                $permissionService->reset()->user($member->user);
            @endphp
            <div class="grid grid-cols-2 {{ $cols }} md: gap-2">
                <div class="col-span-2 md:col-span-1 flex items-center gap-2">
                    <div class="flex-none">
                        @if ($member->user->hasAvatar())
                            <x-users.avatar :user="$member->user" class="w-8 h-8" />
                        @else
                            <div class="rounded-full w-8 h-8 cover-background bg-neutral text-neutral-content uppercase flex items-center justify-center">
                                {{ $member->user->initials() }}
                            </div>
                        @endif
                    </div>
                    <div class="truncate">
                        {!! $member->user->name !!}
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.view') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::View->value }}]"
                            :options="$actions"
                            :selected="$permissionService->action(\App\Enums\Permission::View)->selected('user')"
                            class="join-item permission-control"
                            :label="__('permissions.helpers.view')" />
                        @if ($permissionService->inherited())
                            @php
                                $inheritedHelper = __('permissions.members.inherited', [
                                    'role' => e($permissionService->inheritedRoleName()),
                                    'member' => $member->user->name
                                ]);
                            @endphp
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ $inheritedHelper }}" data-toggle="tooltip" data-append="parent">
                                <i class="text-{{ $permissionService->inheritedRoleAccess() ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                                <span class="sr-only">{{ $inheritedHelper }}</span>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.edit') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::Update->value }}]"
                            :options="$actions"
                            :selected="$permissionService->action(\App\Enums\Permission::Update)->selected('user')"
                            class="join-item permission-control"
                            :label="__('permissions.helpers.edit')" />
                        @if ($permissionService->inherited())
                            @php
                                $inheritedHelper = __('permissions.members.inherited', [
                                    'role' => e($permissionService->inheritedRoleName()),
                                    'member' => $member->user->name
                                ]);
                            @endphp
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ $inheritedHelper }}" data-toggle="tooltip" data-append="parent">
                                <i class="text-{{ $permissionService->inheritedRoleAccess() ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                                <span class="sr-only">{{ $inheritedHelper }}</span>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('crud.permissions.actions.delete') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::Delete->value }}]"
                            :options="$actions"
                            :selected="$permissionService->action(\App\Enums\Permission::Delete)->selected('user')"
                            class="join-item permission-control"
                            :label="__('permissions.helpers.delete')" />
                        @if ($permissionService->inherited())
                            @php
                                $inheritedHelper = __('permissions.members.inherited', [
                                    'role' => e($permissionService->inheritedRoleName()),
                                    'member' => $member->user->name
                                ]);
                            @endphp
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ $inheritedHelper }}" data-toggle="tooltip" data-append="parent">
                                <i class="text-{{ $permissionService->inheritedRoleAccess() ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                                <span class="sr-only">{{  $inheritedHelper }}</span>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <label class="inline md:hidden">{{ __('entities.posts') }}</label>
                    <div class="join w-full field">
                        <x-forms.select
                            name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::Posts->value }}]"
                            :options="$actions"
                            :selected="$permissionService->action(\App\Enums\Permission::Posts)->selected('user')"
                            class="join-item permission-control"
                            :label="__('entities.posts')" />
                        @if ($permissionService->inherited())
                            @php
                                $inheritedHelper = __('permissions.members.inherited', [
                                    'role' => e($permissionService->inheritedRoleName()),
                                    'member' => $member->user->name
                                ]);
                            @endphp
                            <span class="join-item flex items-center bg-base-200 p-2 rounded" data-title="{{ $inheritedHelper }}" data-toggle="tooltip" data-append="parent">
                                <i class="text-{{ $permissionService->inheritedRoleAccess() ? 'green-500' : 'red-500' }} fa-solid fa-check-circle" aria-hidden="true"></i>
                                <span class="sr-only">{{ $inheritedHelper}}</span>
                            </span>
                        @endif
                    </div>
                </div>
                @if ($hasActionCol)
                    @can('switch', $member)
                        <div class="flex items-center">
                            <a class="btn2 btn-outline btn-xs btn-view-as" href="{{ route('identity.switch-entity', [$campaign, $member, $entity]) }}" data-title="{{ __('campaigns.members.helpers.switch') }}" data-toggle="tooltip">
                                {{ __('campaigns.members.actions.switch-entity') }}
                                <x-icon class="fa-solid fa-sign-in-alt" />
                            </a>
                        </div>
                    @endcan
                @endif
            </div>
        @endforeach
    @endif
</div>
