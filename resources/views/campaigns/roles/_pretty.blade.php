<?php
/**
 * @var \App\Services\PermissionService $permission
 * @var \App\Models\CampaignRole $role
 */
$first = true;
?>
<div class="grid grid-cols-6 md:grid-cols-7 gap-2 mb-5 min-w-min">
@foreach ($permission->permissions($role) as $entity => $permissions)
    @if ($first)
        <div class="visible-sm visible-md visible-lg">
        </div>
        @foreach ($permissions as $perm)
            <div class="text-center tooltip-wide">
                <label>
                    <span class="hidden-xs">
                        {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                        <i class="fa-solid fa-question-circle text-link cursor-pointer" aria-hidden="true" data-target="permission-modal" data-toggle="dialog"></i>
                        <br />
                    </span>
                    <input type="checkbox" class="permission-toggle" data-action="{{ $perm['action'] }}" title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" />

                    <span class="visible-xs-inline">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}</span>
                </label>
            </div>
        @endforeach
        @php $first = false; @endphp
    @endif
        <div class="col-span-7 md:col-span-1">
            <strong>{{ __($permission->entityType($entity)) }}</strong>
            @if (!$campaign->enabled($permission->entityTypePlural($entity)))
                <div class="inline" data-toggle="tooltip" title="{{ __('campaigns.modules.permission-disabled') }}">
                    <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                    <span class="hidden-sm hidden-md hidden-lg text-sm inline">{{ __('campaigns.modules.permission-disabled') }}</span>
                </div>
            @endif
        </div>
    @foreach ($permissions as $perm)
        <div class="text-center">
            <div class="pretty p-icon p-toggle p-plain" title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" data-toggle="tooltip">
                {!! Form::checkbox('permissions[' . $perm['key'] . ']', $entity, $perm['enabled'], ['data-action' => $perm['action']]) !!}
                <div class="state p-success-o p-on">
                    <i class="icon {{ $perm['icon'] }}"></i>
                    <label class="visible-xs">
                        {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                    </label>
                </div>
                <div class="state p-off">
                    <i class="icon {{ $perm['icon'] }}"></i>
                    <label class="visible-xs">
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

<div class="grid grid-cols-4 md:grid-cols-5 gap-2 mb-2">
@foreach ($permission->campaignPermissions($role) as $entity => $permissions)
    @if ($first)
        <div class="hidden-xs">
        </div>

        @foreach ($permissions as $perm)
            <div class="hidden-xs text-center tooltip-wide">
                <label>
        <span class="hidden-xs">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}@if($perm['action'] == \App\Models\CampaignPermission::ACTION_POSTS)
                <i class="fa-solid fa-question-circle" data-placement="bottom" data-toggle="tooltip" title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}"></i>
            @endif<br /></span>
                    <input type="checkbox" class="permission-toggle" data-action="{{ $perm['action'] }}" title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" />

                    <span class="visible-xs-inline">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}</span>
                </label>
            </div>
        @endforeach
        @php $first = false; @endphp
    @endif

    <div class="col-span-4 md:col-span-1">
        <strong>{{ __('entities.' . $entity) }}</strong>
    </div>
    @foreach ($permissions as $perm)
        <div class="text-center">
            <div class="pretty p-icon p-toggle p-plain" title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" data-toggle="tooltip">
                {!! Form::checkbox('permissions[' . $perm['key'] . ']', $entity, $perm['enabled'], ['data-action' => $perm['action']]) !!}
                <div class="state p-success-o p-on">
                    <i class="icon {{ $perm['icon'] }}"></i>
                    <label class="visible-xs">
                        {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                    </label>
                </div>
                <div class="state p-off">
                    <i class="icon {{ $perm['icon'] }}"></i>
                    <label class="visible-xs">
                        {{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}
                    </label>
                </div>
            </div>
        </div>
    @endforeach
@endforeach
</div>
