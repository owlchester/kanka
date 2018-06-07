@inject('permissionService', 'App\Services\PermissionService')
<?php $permissions = $permissionService->entityPermissions($entity); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        @if ($ajax)
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
        @endif
            <h4>{{ trans('crud.permissions.title') }}</h4>
    </div>
    <div class="panel-body">
        <p class="text-muted">{{ trans('crud.permissions.helper') }}</p>

        {!! Form::open(['route' => ['entities.permissions', $entity->id], 'method'=>'POST', 'data-shortcut' => "1"]) !!}
        <table id="crud_permissions" class="table table-hover export-hidden">
            <tbody>
                <tr>
                    <th>{{ trans('crud.permissions.fields.role') }}</th>
                    <th>{{ trans('crud.permissions.actions.read') }}</th>
                    <th>{{ trans('crud.permissions.actions.edit') }}</th>
                    <th>{{ trans('crud.permissions.actions.delete') }}</th>
                </tr>
                @foreach (Auth::user()->campaign->roles as $role)
                    @if (!$role->is_admin)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <label>
                                {!! Form::checkbox('role[' . $role->id . '][]', 'read', !empty($permissions['role'][$role->id]['read'])) !!}
                                {{ trans('crud.permissions.allowed') }}
                            </label>
                        </td>
                        <td>
                            <label>
                                {!! Form::checkbox('role[' . $role->id . '][]', 'edit', !empty($permissions['role'][$role->id]['edit'])) !!}
                                {{ trans('crud.permissions.allowed') }}
                            </label>
                        </td>
                        <td>
                            <label>
                                {!! Form::checkbox('role[' . $role->id . '][]', 'delete', !empty($permissions['role'][$role->id]['delete'])) !!}
                                {{ trans('crud.permissions.allowed') }}
                            </label>
                        </td>
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <th>{{ trans('crud.permissions.fields.member') }}</th>
                    <th>{{ trans('crud.permissions.actions.read') }}</th>
                    <th>{{ trans('crud.permissions.actions.edit') }}</th>
                    <th>{{ trans('crud.permissions.actions.delete') }}</th>
                </tr>
                @foreach (Auth::user()->campaign->members()->with('user')->get() as $member)
                    @if (!$member->isAdmin())
                    <tr>
                        <td>{{ $member->user->name }}</td>
                        <td>
                            <label>
                            {!! Form::checkbox('user[' . $member->user_id . '][]', 'read', !empty($permissions['user'][$member->user_id]['read'])) !!}
                                {{ trans('crud.permissions.allowed') }}
                            </label>
                        </td>
                        <td>
                            <label>
                            {!! Form::checkbox('user[' . $member->user_id . '][]', 'edit', !empty($permissions['user'][$member->user_id]['edit'])) !!}
                                {{ trans('crud.permissions.allowed') }}
                            </label>
                        </td>
                        <td>
                            <label>
                            {!! Form::checkbox('user[' . $member->user_id . '][]', 'delete', !empty($permissions['user'][$member->user_id]['delete'])) !!}
                                {{ trans('crud.permissions.allowed') }}
                            </label>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>


        {!! Form::hidden('entity_id', $entity->id) !!}

        <div class="form-group">
            <button class="btn btn-success">{{ trans('crud.save') }}</button>
        </div>

        {!! Form::close() !!}

    </div>
</div>