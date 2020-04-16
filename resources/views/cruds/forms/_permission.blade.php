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
@endphp

<p class="help-block">{{ __('crud.permissions.helper') }}</p>

<table id="crud_permissions" class="crud_permissions table table-hover export-hidden">
    <tbody>
    <tr>
        <th>{{ __('crud.permissions.fields.role') }}</th>
        <th><i class="fa fa-eye visible-xs visible-sm" title="{{ __('crud.permissions.actions.read') }}"></i></th>
        <th><i class="fa fa-edit visible-xs visible-sm" title="{{ __('crud.permissions.actions.edit') }}"></i></th>
        <th><i class="fa fa-trash visible-xs visible-sm" title="{{ __('crud.permissions.actions.delete') }}"></i></th>
        <th><i class="fa fa-sticky-note visible-xs visible-sm" title="{{ __('crud.permissions.actions.entity_note') }}"></i></th>
    </tr>
    @foreach ($campaign->campaign()->roles as $role)
        @if (!$role->is_admin)
            <tr>
                <td>{{ $role->name }}</td>
                <td @if($role->is_public) colspan="4"@endif>
                    <label>
                        {!! Form::checkbox('role[' . $role->id . '][]', 'read', !empty($permissions['role'][$role->id]['read'])) !!}
                        <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.read') }}</span>

                        @if ($permissionService->inherited('read', $role->id))
                            <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                        @endif
                    </label>
                </td>
                @if (!$role->is_public)
                    <td>
                        <label>
                            {!! Form::checkbox('role[' . $role->id . '][]', 'edit', !empty($permissions['role'][$role->id]['edit'])) !!}
                            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.edit') }}</span>

                            @if ($permissionService->inherited('edit', $role->id))
                                <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                            @endif
                        </label>
                    </td>
                    <td>
                        <label>
                            {!! Form::checkbox('role[' . $role->id . '][]', 'delete', !empty($permissions['role'][$role->id]['delete'])) !!}
                            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.delete') }}</span>

                            @if ($permissionService->inherited('delete', $role->id))
                                <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited') }}" data-toggle="tooltip"></i>
                            @endif
                        </label>
                    </td>
                    <td>
                        <label>
                            {!! Form::checkbox('role[' . $role->id . '][]', 'entity-note', !empty($permissions['role'][$role->id]['entity-note'])) !!}
                            <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.entity_note') }}</span>

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
        <th colspan="5">{{ __('crud.permissions.fields.member') }}</th>
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
                        {!! Form::checkbox('user[' . $member->user_id . '][]', 'read', !empty($permissions['user'][$member->user_id]['read'])) !!}
                        <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.read') }}</span>

                        @if ($permissionService->inherited('read', 0, $member->user_id))
                            <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                               'role' => e($permissionService->inheritedRole('read', $member->user_id))
                           ]) }}" data-toggle="tooltip"></i>
                        @endif
                    </label>
                </td>
                <td>
                    <label>
                        {!! Form::checkbox('user[' . $member->user_id . '][]', 'edit', !empty($permissions['user'][$member->user_id]['edit'])) !!}
                        <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.edit') }}</span>

                        @if ($permissionService->inherited('edit', 0, $member->user_id))
                            <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                               'role' => e($permissionService->inheritedRole('edit', $member->user_id))
                           ]) }}" data-toggle="tooltip"></i>
                        @endif
                    </label>
                </td>
                <td>
                    <label>
                        {!! Form::checkbox('user[' . $member->user_id . '][]', 'delete', !empty($permissions['user'][$member->user_id]['delete'])) !!}
                        <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.delete') }}</span>

                        @if ($permissionService->inherited('delete', 0, $member->user_id))
                            <i class="text-green fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                               'role' => e($permissionService->inheritedRole('delete', $member->user_id))
                           ]) }}" data-toggle="tooltip"></i>
                        @endif
                    </label>
                </td>
                <td>
                    <label>
                        {!! Form::checkbox('user[' . $member->user_id . '][]', 'entity-note', !empty($permissions['user'][$member->user_id]['entity-note'])) !!}
                        <span class="hidden-xs hidden-sm">{{ __('crud.permissions.actions.entity_note') }}</span>

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
