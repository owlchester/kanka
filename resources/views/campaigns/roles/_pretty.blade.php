<?php
/**
 * @var \App\Services\PermissionService $permission
 * @var \App\Models\CampaignRole $role
 */
$first = true;
?>
@foreach ($permission->permissions($role) as $entity => $permissions)
    @if ($first)
    <div class="row margin-bottom">
        <div class="col-sm-4 col-md-3 col-xl-2">
            <strong class="visible-xs">{{ __('campaigns.roles.permissions.actions.toggle') }}</strong>
        </div>
        <div class="col-sm-8 col-md-9 col-xl-10">
            <div class="row">
            @foreach ($permissions as $perm)
                <div class="col-sm-2 text-center tooltip-wide">
                    <label>
                        <span class="hidden-xs">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}<br /></span>
                        <input type="checkbox" class="permission-toggle" data-action="{{ $perm['action'] }}" title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" />

                            <span class="visible-xs-inline">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}</span>
                    </label>
                </div>
            @endforeach
            </div>
        </div>
    </div>
        @php $first = false; @endphp
    @endif
    <div class="row margin-bottom">
        <div class="col-sm-4 col-md-3 col-xl-2">
            <strong>{{ __($permission->entityType($entity)) }}</strong>
        </div>
        <div class="col-sm-8 col-md-9 col-xl-10">
            <div class="row">
            @foreach ($permissions as $perm)
                <div class="col-sm-2 text-center">
                    <div class="pretty p-icon p-toggle p-plain" title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" data-toggle="tooltip">
                        {!! Form::checkbox('permissions[' . $perm['key'] . ']', $entity, $perm['enabled'], ['data-action' => $perm['action']]) !!}
                        <div class="state p-success-o p-on">
                            <i class="icon {{ $perm['icon'] }}"></i>
                            <label class="visible-xs">
                                {{ __('campaigns.roles.permissions.actions.' . $perm['action']) }}
                            </label>
                        </div>
                        <div class="state p-off">
                            <i class="icon {{ $perm['icon'] }}"></i>
                            <label class="visible-xs">
                                {{ __('campaigns.roles.permissions.actions.' . $perm['action']) }}
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
@endforeach


@if(!$role->is_public)
<?php
/** @var \App\Services\PermissionService $permission */
$first = true;
?>
@foreach ($permission->campaignPermissions($role) as $entity => $permissions)
    @if ($first)
        <div class="row margin-bottom">
            <div class="col-sm-4 col-md-3 col-xl-2">
                <strong class="visible-xs">{{ __('campaigns.roles.permissions.actions.toggle') }}</strong>
            </div>
            <div class="col-sm-8 col-md-9 col-xl-10">
                <div class="row">
                    @foreach ($permissions as $perm)
                        <div class="col-sm-2 text-center tooltip-wide">
                            <label>
                        <span class="hidden-xs">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}@if($perm['action'] == \App\Models\CampaignPermission::ACTION_POSTS)
                                <i class="fa fa-question-circle" data-placement="bottom" data-toggle="tooltip" title="{{ __('campaigns.roles.permissions.helpers.entity_note') }}"></i>
                            @endif<br /></span>
                                <input type="checkbox" class="permission-toggle" data-action="{{ $perm['action'] }}" title="{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}" />

                                <span class="visible-xs-inline">{{ __('campaigns.roles.permissions.actions.' . $perm['label']) }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @php $first = false; @endphp
    @endif
    <div class="row margin-bottom">
        <div class="col-sm-4 col-md-3 col-xl-2">
            <strong>{{ __('entities.' . $entity) }}</strong>
        </div>
        <div class="col-sm-8 col-md-9 col-xl-10">
            <div class="row">
                @foreach ($permissions as $perm)
                    <div class="col-sm-2 text-center">
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
            </div>
        </div>
    </div>
@endforeach
@endif
