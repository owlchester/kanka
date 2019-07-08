@inject('permissionService', 'App\Services\PermissionService')
<?php $permissions = isset($model) ? $permissionService->entityPermissions($model->entity) : []; ?>

<p class="text-muted">{{ trans('crud.permissions.helper') }}</p>

<table id="crud_permissions" class="table table-hover export-hidden">
    <tbody>
    <tr>
        <th colspan="5">{{ trans('crud.permissions.fields.role') }}</th>
    </tr>
    @foreach (Auth::user()->campaign->roles as $role)
        @if (!$role->is_admin)
            <tr>
                <td>{{ $role->name }}</td>
                <td @if($role->is_public) colspan="4"@endif>
                    <label>
                        {!! Form::checkbox('role[' . $role->id . '][]', 'read', !empty($permissions['role'][$role->id]['read'])) !!}
                        <span class="hidden-xs hidden-sm">{{ trans('crud.permissions.actions.read') }}</span>
                    </label>
                </td>
                @if (!$role->is_public)
                    <td>
                        <label>
                            {!! Form::checkbox('role[' . $role->id . '][]', 'edit', !empty($permissions['role'][$role->id]['edit'])) !!}
                            <span class="hidden-xs hidden-sm">{{ trans('crud.permissions.actions.edit') }}</span>
                        </label>
                    </td>
                    <td>
                        <label>
                            {!! Form::checkbox('role[' . $role->id . '][]', 'delete', !empty($permissions['role'][$role->id]['delete'])) !!}
                            <span class="hidden-xs hidden-sm">{{ trans('crud.permissions.actions.delete') }}</span>
                        </label>
                    </td>
                    <td>
                        <label>
                            {!! Form::checkbox('role[' . $role->id . '][]', 'entity-note', !empty($permissions['role'][$role->id]['entity-note'])) !!}
                            <span class="hidden-xs hidden-sm">{{ trans('crud.permissions.actions.entity_note') }}</span>
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
        <th colspan="5">{{ trans('crud.permissions.fields.member') }}</th>
    </tr>
    @foreach (Auth::user()->campaign->members()->with('user')->get() as $member)
        @if (!$member->isAdmin())
            <tr>
                <td>{{ $member->user->name }}</td>
                <td>
                    <label>
                        {!! Form::checkbox('user[' . $member->user_id . '][]', 'read', !empty($permissions['user'][$member->user_id]['read'])) !!}
                        <span class="hidden-xs hidden-sm">{{ trans('crud.permissions.actions.read') }}</span>
                    </label>
                </td>
                <td>
                    <label>
                        {!! Form::checkbox('user[' . $member->user_id . '][]', 'edit', !empty($permissions['user'][$member->user_id]['edit'])) !!}
                        <span class="hidden-xs hidden-sm">{{ trans('crud.permissions.actions.edit') }}</span>
                    </label>
                </td>
                <td>
                    <label>
                        {!! Form::checkbox('user[' . $member->user_id . '][]', 'delete', !empty($permissions['user'][$member->user_id]['delete'])) !!}
                        <span class="hidden-xs hidden-sm">{{ trans('crud.permissions.actions.delete') }}</span>
                    </label>
                </td>
                <td>
                    <label>
                        {!! Form::checkbox('user[' . $member->user_id . '][]', 'entity-note', !empty($permissions['user'][$member->user_id]['entity-note'])) !!}
                        <span class="hidden-xs hidden-sm">{{ trans('crud.permissions.actions.entity_note') }}</span>
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>