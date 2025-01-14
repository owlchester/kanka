<?php
/**
 * @var \App\Services\Permissions\RolePermissionService $permissionService
 * @var \App\Models\CampaignRole $role
 */
$first = true;
?>
<div class="grid grid-cols-6 md:grid-cols-7 gap-2">
@foreach ($permissionService->permissions() as $permissions)
    @if ($first)
        <div class="hidden sm:block"></div>
        @foreach ($permissions['permissions'] as $perm)
            <div class="text-center tooltip-wide  md:w-40 flex gap-2 justify-center">
                <label class="">
                    <span class="hidden sm:inline">
                        {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                        <i class="fa-solid fa-question-circle text-link cursor-pointer" aria-hidden="true" data-target="permission-modal" data-toggle="dialog"></i>
                        <br />
                    </span>
                    <input type="checkbox" class="permission-toggle" data-action="{{ $perm['action'] }}" title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" />

                    <span class="inline sm:hidden">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}</span>
                </label>
            </div>
        @endforeach
        @php $first = false; @endphp
    @endif
    <div class="col-span-7 md:col-span-1 md:w-40">
        <div class="font-extrabold truncate inline">
            {!! $permissions['entityType']->plural() !!}
        </div>
        @if (($permissions['entityType']->isSpecial() && !$permissions['entityType']->isEnabled()) || (!$permissions['entityType']->isSpecial() && !$campaign->enabled($permissions['entityType']->pluralCode())))
            <div class="inline" data-toggle="tooltip" data-title="{{ __('campaigns.modules.permission-disabled') }}">
                <x-icon class="fa-solid fa-exclamation-triangle" />
                <span class="inline sm:hidden text-sm">{{ __('campaigns.modules.permission-disabled') }}</span>
            </div>
        @endif
    </div>
    @foreach ($permissions['permissions'] as $perm)
        <div class="text-center md:w-40 overflow-hidden">
            <div class="pretty p-icon p-toggle p-plain" data-title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" data-toggle="tooltip">
                <input type="checkbox" name="permissions[{{ $perm['key'] }}]" value="{{ $permissions['entityType']->id }}" @if ($perm['enabled']) checked="checked" @endif data-action="{{ $perm['action'] }}" />
                <div class="state p-success-o p-on">
                    <x-icon class="icon {{ $perm['icon'] }}" />
                    <label class="sm:hidden">
                        {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                    </label>
                </div>
                <div class="state p-off">
                    <x-icon class="icon {{ $perm['icon'] }}" />
                    <label class="sm:hidden">
                        {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                    </label>
                </div>
            </div>
        </div>
    @endforeach
@endforeach
</div>

@php $first = true; @endphp

<hr />

<div class="grid grid-cols-3 md:grid-cols-4 gap-2">
@foreach ($permissionService->campaignPermissions() as $entity => $permissions)
    @if ($first && false)
        <div class="hidden sm:inline">
        </div>

        @foreach ($permissions as $perm)
            <div class="hidden sm:flex text-center tooltip-wide gap-2 justify-center">
                <label>
        <span class="hidden sm:inline">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}@if($perm['action'] == \App\Models\CampaignPermission::ACTION_POSTS)
                <i class="fa-solid fa-question-circle" data-placement="bottom" data-toggle="tooltip" data-title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}"></i>
            @endif<br /></span>
                    <input type="checkbox" class="permission-toggle" data-action="{{ $perm['action'] }}" title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" />

                    <span class="inline sm:hidden">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}</span>
                </label>
            </div>
        @endforeach
        @php $first = false; @endphp
    @endif

    <div class="col-span-3 md:col-span-1">
        <strong>{{ __('entities.' . $entity) }}</strong>
    </div>
    @foreach ($permissions as $perm)
        <div class="md:w-40 overflow-hidden">
            <div class="pretty p-icon p-toggle p-plain" data-title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" data-toggle="tooltip">
                <input type="checkbox" name="permissions[{{ $perm['key'] }}]" value="{{ $entity }}" @if ($perm['enabled']) checked="checked" @endif data-action="{{ $perm['action'] }}" />
                <div class="state p-success-o p-on">
                    <x-icon class="icon {{ $perm['icon'] }}" />
                    <label class="sm:hidden">
                        {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                    </label>
                </div>
                <div class="state p-off">
                    <x-icon class="icon {{ $perm['icon'] }}" />
                    <label class="sm:hidden">
                        {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                    </label>
                </div>
            </div>
        </div>
    @endforeach

@endforeach
</div>

<div class="grid grid-cols-3 md:grid-cols-4 gap-2">
    <div class="col-span-3 md:col-span-1">
        <strong>{{ __('sidebar.gallery') }}</strong>
    </div>
    @foreach ($permissionService->galleryPermissions() as $entity => $permissions)
        @foreach ($permissions as $perm)
            <div class="md:w-40 overflow-hidden">
                <div class="pretty p-icon p-toggle p-plain" data-title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" data-toggle="tooltip">
                    <input type="checkbox" name="permissions[{{ $perm['key'] }}]" value="{{ $entity }}" @if ($perm['enabled']) checked="checked" @endif data-action="{{ $perm['action'] }}" />
                    <div class="state p-success-o p-on">
                        <x-icon class="icon {{ $perm['icon'] }}" />
                        <label class="sm:hidden">
                            {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                        </label>
                    </div>
                    <div class="state p-off">
                        <x-icon class="icon {{ $perm['icon'] }}" />
                        <label class="sm:hidden">
                            {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>

<div class="grid grid-cols-3 md:grid-cols-4 gap-2">
    <div class="col-span-3 md:col-span-1">
        <strong>{{ __('entities.templates') }}</strong>
    </div>
    @foreach ($permissionService->templatePermissions() as $entity => $permissions)
        @foreach ($permissions as $perm)
            <div class="md:w-40 overflow-hidden">
                <div class="pretty p-icon p-toggle p-plain" data-title="{{ __('entities.' . $perm['label']) }}" data-toggle="tooltip">
                    <input type="checkbox" name="permissions[{{ $perm['key'] }}]" value="{{ $entity }}" @if ($perm['enabled']) checked="checked" @endif data-action="{{ $perm['action'] }}" />
                    <div class="state p-success-o p-on">
                        <x-icon class="icon {{ $perm['icon'] }}" />
                        <label class="sm:hidden">
                            {{ __('entities.' . $perm['label']) }}
                        </label>
                    </div>
                    <div class="state p-off">
                        <x-icon class="icon {{ $perm['icon'] }}" />
                        <label class="sm:hidden">
                            {{ __('entities.' . $perm['label']) }}
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>

<div class="grid grid-cols-3 md:grid-cols-4 gap-2">
    <div class="col-span-3 md:col-span-1">
        <strong>{{ __('entities.bookmarks') }}</strong>
    </div>
    @foreach ($permissionService->bookmarkPermissions() as $entity => $permissions)
        @foreach ($permissions as $perm)
            <div class="md:w-40 overflow-hidden">
                <div class="pretty p-icon p-toggle p-plain" data-title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" data-toggle="tooltip">
                    <input type="checkbox" name="permissions[{{ $perm['key'] }}]" value="{{ $entity }}" @if ($perm['enabled']) checked="checked" @endif data-action="{{ $perm['action'] }}" />
                    <div class="state p-success-o p-on">
                        <x-icon class="icon {{ $perm['icon'] }}" />
                        <label class="sm:hidden">
                            {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                        </label>
                    </div>
                    <div class="state p-off">
                        <x-icon class="icon {{ $perm['icon'] }}" />
                        <label class="sm:hidden">
                            {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>
