@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('crud.permissions.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($entity->pluralType() . '.index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => route($entity->pluralType() . '.show', $entity->child->id), 'label' => $entity->name],
        trans('crud.update'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @inject('permissionService', 'App\Services\PermissionService')
    <?php $permissions = $permissionService->entityPermissions($entity); ?>

    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>{{ trans('crud.permissions.title', ['name' => $entity->name]) }}</h4>
            </div>
        @endif
        <div class="panel-body">
            <p class="text-muted">{{ trans('crud.permissions.helper') }}</p>

            @include('partials.errors')

            @notEnv('shadow')
            {!! Form::open(['route' => ['entities.permissions', $entity->id], 'method'=>'POST', 'data-shortcut' => "1"]) !!}
            @endif
            <table id="crud_permissions" class="table table-hover export-hidden">
                <tbody>
                <tr>
                    <th colspan="4">{{ trans('crud.permissions.fields.role') }}</th>
                </tr>
                @foreach (Auth::user()->campaign->roles()->withoutAdmin()->get() as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td @if($role->is_public) colspan="3"@endif>
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
                @endforeach
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <th colspan="4">{{ trans('crud.permissions.fields.member') }}</th>
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


            @notEnv('shadow')
            {!! Form::hidden('entity_id', $entity->id) !!}

            <div class="form-group">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
            </div>

            {!! Form::close() !!}
            @endif

        </div>
    </div>
@endsection