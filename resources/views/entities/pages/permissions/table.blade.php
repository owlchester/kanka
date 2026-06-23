<?php
/**
 * @var \App\Services\PermissionService $permissionService
 * @var \App\Models\CampaignUser $member
 * @var \App\Models\EntityType? $entityType
 * @var \App\Models\Entity? $entityType
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 */
$permissionService->campaign($campaign);
$hasActionCol = isset($showPermissionActions) && auth()->user()->can('admin', $campaign);
$cols = 'md:grid-cols-5';
if ($hasActionCol) {
    $cols = 'md:grid-cols-6';
}
$moduleName = isset($entityType) ? $entityType->name() : $entity->entityType->name();
?>

<x-grid type="1/1" class="max-w-4xl">
    <x-helper>
        <p>{!! __('crud.permissions.helpers.setup', [
            'allow' => '<span class="text-green-700 font-medium">' . __('crud.permissions.actions.bulk_entity.allow') . '</span>',
            'deny' => '<span class="text-red-600 font-medium">' . __('crud.permissions.actions.bulk_entity.deny') . '</span>',
            'inherit' => '<span class="text-neutral-content font-medium">' . __('crud.permissions.actions.bulk_entity.inherit') . '</span>',
            'docs' => '<a href="https://docs.kanka.io/en/latest/features/permissions.html#entry-permissions" target="_blank" class="text-link">' . __('general.learn-more') . '</a>',
        ]) !!}</p>
    </x-helper>
    
    <div id="crud_permissions" class="flex flex-col gap-4 ">
        <div id="roles-permissions" class="flex flex-col gap-2 relative">
            <div class="hidden md:grid {{ $cols }} gap-2 md:gap-4 @if (!request()->ajax()) sticky top-12 z-10 bg-base-100 py-2 @endif ">
                <div class="w-40 ">
                    <span class="font-medium uppercase text-neutral-content">{{ __('crud.permissions.fields.role') }}</span>
                </div>
                <div class="" data-title="{{ __('permissions.helpers.view') }}" data-tooltip>
                    <span class="font-medium">{{ __('crud.permissions.actions.view') }}</span>
                </div>
                <div class="" data-title="{{ __('permissions.helpers.edit') }}" data-tooltip>
                    <span class="font-medium">{{ __('crud.permissions.actions.edit') }}</span>
                </div>
                <div class="" data-title="{{ __('permissions.helpers.delete') }}" data-tooltip>
                    <span class="font-medium">{{ __('crud.permissions.actions.delete') }}</span>
                </div>
                <div class="" data-title="{{ __('campaigns.roles.permissions.helpers.articles') }}" data-tooltip>
                    <span class="font-medium">{{ __('entities.articles') }}</span>
                </div>
                @if ($hasActionCol)
                    <div class="">
                        <span class="font-medium">{{ __('crud.actions.actions') }}</span>
                    </div>
                @endif
            </div>
            @foreach ($campaign->roles()->withoutAdmin()->get() as $role)
                @php $permissionService->reset()->role($role) @endphp
                <div class="grid grid-cols-2 {{ $cols }} gap-2 md:gap-4 items-center">
                    <div class="w-40 col-span-2 md:col-span-1 font-medium">
                        @can('update', $role)
                            <a href="{{ route('campaign_roles.show', [$campaign, $role]) }}" class="text-link">
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
                        @php $permissionService->action(\App\Enums\Permission::View) @endphp
                        <x-forms.permission-toggle
                            name="role[{{ $role->id }}][{{ \App\Enums\Permission::View->value }}]"
                            :selected="$permissionService->selected('role')"
                            :inherited="$permissionService->inherited()"
                            :label="__('permissions.helpers.view')" />
                    </div>
                    @if (!$role->isPublic())
                        <div class="">
                            @php $permissionService->action(\App\Enums\Permission::Update) @endphp
                            <x-forms.permission-toggle
                                name="role[{{ $role->id }}][{{ \App\Enums\Permission::Update->value }}]"
                                :selected="$permissionService->selected('role')"
                                :inherited="$permissionService->inherited()"
                                :label="__('permissions.helpers.edit')" />
                        </div>
                        <div class="">
                            @php $permissionService->action(\App\Enums\Permission::Delete) @endphp
                            <x-forms.permission-toggle
                                name="role[{{ $role->id }}][{{ \App\Enums\Permission::Delete->value }}]"
                                :selected="$permissionService->selected('role')"
                                :inherited="$permissionService->inherited()"
                                :label="__('permissions.helpers.delete')" />
                        </div>
                        <div class="">
                            @php $permissionService->action(\App\Enums\Permission::Posts) @endphp
                            <x-forms.permission-toggle
                                name="role[{{ $role->id }}][{{ \App\Enums\Permission::Posts->value }}]"
                                :selected="$permissionService->selected('role')"
                                :inherited="$permissionService->inherited()"
                                :label="__('entities.articles')" />
                        </div>
                    @else
                        <div></div>
                        <div></div>
                        <div></div>
                    @endif
                </div>
            @endforeach
        </div>
    
        @if (isset($skipUsers) && $skipUsers && !empty(config('limits.campaigns.members')) &&$campaign->nonAdminMembers->count() > config('limits.campaigns.members'))
            <x-helper>
                <p>{{ __('crud.permissions.too_many_members', ['number' => config('limits.campaigns.members')]) }}</p>
            </x-helper>
            <input type="hidden" name="permissions_too_many" value="1" />
        @else
    
            <div id="members-permissions" class="relative flex flex-col gap-2">
                <div class="hidden md:grid {{ $cols }} gap-2 md:gap-4 justify-center @if (!request()->ajax()) sticky top-12 z-10 bg-base-100 py-2 @endif">
                    <div class="font-medium uppercase text-neutral-content">{{ __('crud.permissions.fields.member') }}</div>
    
                    <div class="" data-title="{{ __('permissions.helpers.view') }}" data-tooltip>
                        <span class="font-medium">{{ __('crud.permissions.actions.view') }}</span>
                    </div>
                    <div class="" data-title="{{ __('permissions.helpers.edit') }}" data-tooltip>
                        <span class="font-medium">{{ __('crud.permissions.actions.edit') }}</span>
                    </div>
                    <div class="" data-title="{{ __('permissions.helpers.delete') }}" data-tooltip>
                        <span class="font-medium">{{ __('crud.permissions.actions.delete') }}</span>
                    </div>
                    <div class="" data-title="{{ __('campaigns.roles.permissions.helpers.articles') }}" data-tooltip>
                        <span class="font-medium">{{ __('entities.articles') }}</span>
                    </div>
                    @if ($hasActionCol)
                        <div class="">
                            <span class="font-medium">{{ __('crud.actions.actions') }}</span>
                        </div>
                    @endif
                </div>
                @foreach ($campaign->nonAdminMembers as $member)
                    @php
                        $permissionService->reset()->user($member->user);
                    @endphp
                    <div class="grid grid-cols-2 {{ $cols }} gap-2 md:gap-4">
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
                            <div class="truncate font-medium">
                                {!! $member->user->name !!}
                            </div>
                        </div>
                        <div class="">
                            @php $permissionService->action(\App\Enums\Permission::View) @endphp
                            <x-forms.permission-toggle
                                name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::View->value }}]"
                                :selected="$permissionService->selected('user')"
                                :inherited="$permissionService->inherited()"
                                :inheritedAccess="$permissionService->inherited() ? $permissionService->inheritedRoleAccess() : true"
                                :label="__('permissions.helpers.view')" />
                        </div>
                        <div class="">
                            @php $permissionService->action(\App\Enums\Permission::Update) @endphp
                            <x-forms.permission-toggle
                                name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::Update->value }}]"
                                :selected="$permissionService->selected('user')"
                                :inherited="$permissionService->inherited()"
                                :inheritedAccess="$permissionService->inherited() ? $permissionService->inheritedRoleAccess() : true"
                                :label="__('permissions.helpers.edit')" />
                        </div>
                        <div class="">
                            @php $permissionService->action(\App\Enums\Permission::Delete) @endphp
                            <x-forms.permission-toggle
                                name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::Delete->value }}]"
                                :selected="$permissionService->selected('user')"
                                :inherited="$permissionService->inherited()"
                                :inheritedAccess="$permissionService->inherited() ? $permissionService->inheritedRoleAccess() : true"
                                :label="__('permissions.helpers.delete')" />
                        </div>
                        <div class="">
                            @php $permissionService->action(\App\Enums\Permission::Posts) @endphp
                            <x-forms.permission-toggle
                                name="user[{{ $member->user_id }}][{{ \App\Enums\Permission::Posts->value }}]"
                                :selected="$permissionService->selected('user')"
                                :inherited="$permissionService->inherited()"
                                :inheritedAccess="$permissionService->inherited() ? $permissionService->inheritedRoleAccess() : true"
                                :label="__('entities.articles')" />
                        </div>
                        @if ($hasActionCol)
                            @can('switch', $member)
                                <div class="flex items-center">
                                    <a class="btn2 btn-outline btn-xs btn-view-as" href="{{ route('identity.switch-entity', [$campaign, $member, $entity]) }}" data-title="{{ __('campaigns.members.helpers.switch') }}" data-toggle="tooltip">
                                        <x-icon class="fa-solid fa-sign-in-alt" />
                                        {{ __('campaigns.members.actions.switch-entity') }}
                                    </a>
                                </div>
                            @endcan
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-grid>