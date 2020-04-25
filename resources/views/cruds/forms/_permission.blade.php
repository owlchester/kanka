@inject('permissionService', 'App\Services\PermissionService')
@php
/**
 * @var \App\Services\PermissionService $permissionService
 * @var \App\Models\CampaignUser $member
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 */
$permissions = isset($model) ? $permissionService->entityPermissions($model->entity) : [];
if (isset($model)) {
    $permissionService->type($entityType);
} else {
    $permissionService->type($entityType);
}
$actions = [
    'access' => __('crud.permissions.actions.bulk_entity.allow'),
    'deny' => __('crud.permissions.actions.bulk_entity.deny'),
    'inherit' => __('crud.permissions.actions.bulk_entity.inherit'),
];
@endphp

<p class="help-block">{{ __('crud.permissions.helper') }}</p>

<table id="crud_permissions" class="crud_permissions table table-hover export-hidden">
    <tbody>
    <tr>
        <th>{{ __('crud.permissions.fields.role') }}</th>
        <th>
            <i class="fa fa-eye visible-xs visible-sm" title="{{ __('crud.permissions.actions.read') }}"></i>
            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.read') }}</span></th>
        <th>
            <i class="fa fa-edit visible-xs visible-sm" title="{{ __('crud.permissions.actions.edit') }}"></i>
            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.edit') }}</span>
        </th>
        <th>
            <i class="fa fa-trash visible-xs visible-sm" title="{{ __('crud.permissions.actions.delete') }}"></i>
            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.delete') }}</span>
        </th>
        <th>
            <i class="fa fa-sticky-note visible-xs visible-sm" title="{{ __('crud.permissions.actions.entity_note') }}"></i>
            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.entity_note') }}</span>
        </th>
    </tr>
    @foreach ($campaign->campaign()->roles as $role)
        @if (!$role->is_admin)
            <tr>
                <td>{{ $role->name }}</td>
                <td @if($role->is_public) colspan="4"@endif>
                    <label>
                        {!! Form::select("role[$role->id][read]", $actions, $permissionService->selected('role', $role->id, 'read')) !!}

                        @if ($permissionService->inherited('read', $role->id))
                            <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                        @endif
                    </label>
                </td>
                @if (!$role->is_public)
                    <td>
                        <label>
                            {!! Form::select("role[$role->id][edit]", $actions, $permissionService->selected('role', $role->id, 'edit')) !!}

                            @if ($permissionService->inherited('edit', $role->id))
                                <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                            @endif
                        </label>
                    </td>
                    <td>
                        <label>
                            {!! Form::select("role[$role->id][delete]", $actions, $permissionService->selected('role', $role->id, 'delete')) !!}

                            @if ($permissionService->inherited('delete', $role->id))
                                <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                            @endif
                        </label>
                    </td>
                    <td>
                        <label>
                            {!! Form::select("role[$role->id][entity-note]", $actions, $permissionService->selected('role', $role->id, 'entity-note')) !!}

                            @if ($permissionService->inherited('entity-note', $role->id))
                                <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                            @endif
                        </label>
                    </td>
                @endif
            </tr>
        @endif
    @endforeach

    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <th>{{ __('crud.permissions.fields.member') }}</th>
        <th>
            <i class="fa fa-eye visible-xs visible-sm" title="{{ __('crud.permissions.actions.read') }}"></i>
            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.read') }}</span></th>
        <th>
            <i class="fa fa-edit visible-xs visible-sm" title="{{ __('crud.permissions.actions.edit') }}"></i>
            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.edit') }}</span>
        </th>
        <th>
            <i class="fa fa-trash visible-xs visible-sm" title="{{ __('crud.permissions.actions.delete') }}"></i>
            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.delete') }}</span>
        </th>
        <th>
            <i class="fa fa-sticky-note visible-xs visible-sm" title="{{ __('crud.permissions.actions.entity_note') }}"></i>
            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.entity_note') }}</span>
        </th>
    </tr>
@if ($campaign->campaign()->members->count() > 10)
    </tbody>
</table>
<p class="help-block">{{ __('crud.permissions.too_many_members') }}</p>
<input type="hidden" name="permissions_too_many" value="1" />
@else
    @foreach ($campaign->campaign()->members()->with('user')->get() as $member)
        @if (!$member->isAdmin())
            <tr>
                <td>
                    <div class="entity-image float-left" style="background-image: url({{ $member->user->getAvatarUrl(true) }})" title="{{ $member->user->name }}">
                    </div>
                    <div class="entity-name-img">{{ $member->user->name }}</div>
                </td>
                <td>
                    <label>
                        {!! Form::select("user[$member->user_id][read]", $actions, $permissionService->selected('user', $member->user_id, 'read')) !!}

                        @if ($permissionService->inherited('read', 0, $member->user_id))
                            <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                               'role' => e($permissionService->inheritedRole('read', $member->user_id))
                           ]) }}" data-toggle="tooltip"></i>
                        @endif
                    </label>
                </td>
                <td>
                    <label>
                        {!! Form::select("user[$member->user_id][edit]", $actions, $permissionService->selected('user', $member->user_id, 'edit')) !!}

                        @if ($permissionService->inherited('edit', 0, $member->user_id))
                            <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                               'role' => e($permissionService->inheritedRole('edit', $member->user_id))
                           ]) }}" data-toggle="tooltip"></i>
                        @endif
                    </label>
                </td>
                <td>
                    <label>
                        {!! Form::select("user[$member->user_id][delete]", $actions, $permissionService->selected('user', $member->user_id, 'delete')) !!}

                        @if ($permissionService->inherited('delete', 0, $member->user_id))
                            <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                               'role' => e($permissionService->inheritedRole('delete', $member->user_id))
                           ]) }}" data-toggle="tooltip"></i>
                        @endif
                    </label>
                </td>
                <td>
                    <label>
                        {!! Form::select("user[$member->user_id][entity-note]", $actions, $permissionService->selected('user', $member->user_id, 'entity-note')) !!}

                        @if ($permissionService->inherited('entity-note', 0, $member->user_id))
                            <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                               'role' => e($permissionService->inheritedRole('entity-note', $member->user_id))
                           ]) }}" data-toggle="tooltip"></i>
                        @endif
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
@endif
