<?php
/**
 * entities/<id>/permissions
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\CampaignUser $member
 */
?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('crud.permissions.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($entity->pluralType() . '.index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => route($entity->pluralType() . '.show', $entity->child->id), 'label' => $entity->name],
        __('crud.update'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @inject('permissionService', 'App\Services\PermissionService')
@php
    /** @var \App\Services\PermissionService $permissionService */
    $permissions = $permissionService->type($entity->type)->entityPermissions($entity);

    $actions = [
        'allow' => __('crud.permissions.actions.bulk_entity.allow'),
        'deny' => __('crud.permissions.actions.bulk_entity.deny'),
        'inherit' => __('crud.permissions.actions.bulk_entity.inherit'),
    ];
@endphp

    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>{{ __('crud.permissions.title', ['name' => $entity->name]) }}</h4>
            </div>
        @endif
        <div class="panel-body">
            <p class="help-block">
                {!! __('crud.permissions.helpers.setup', [
                    'allow' => '<code>' . __('crud.permissions.actions.bulk_entity.allow') . '</code>',
                    'deny' => '<code>' . __('crud.permissions.actions.bulk_entity.deny') . '</code>',
                    'inherit' => '<code>' . __('crud.permissions.actions.bulk_entity.inherit') . '</code>',
                ]) !!}
            </p>

            @include('partials.errors')

            @notEnv('shadow')
            {!! Form::open(['route' => ['entities.permissions', $entity->id], 'method'=>'POST', 'data-shortcut' => "1"]) !!}
            @endif
            <table id="crud_permissions" class="table table-hover export-hidden">
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
                        <i class="fa fa-question-circle" data-toggle="tooltip" title="{{ __('crud.permissions.helpers.entity_note') }}"></i>
                    </th>
                </tr>
                @foreach ($campaign->campaign()->roles()->withoutAdmin()->get() as $role)
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
                        <i class="fa fa-question-circle" data-toggle="tooltip" title="{{ __('crud.permissions.helpers.entity_note') }}"></i>
                    </th>
                </tr>
                @foreach ($campaign->campaign()->members()->withoutAdmins()->with('user')->get() as $member)
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
                                    <i class="text-{{ $permissionService->inheritedRoleAccess('read', $member->user_id) ? 'green' : 'red' }} fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName('read', $member->user_id))
                       ]) }}" data-toggle="tooltip"></i>
                                @endif
                            </label>
                        </td>
                        <td>
                            <label>
                                {!! Form::select("user[$member->user_id][edit]", $actions, $permissionService->selected('user', $member->user_id, 'edit')) !!}
                                @if ($permissionService->inherited('edit', 0, $member->user_id))
                                    <i class="text-{{ $permissionService->inheritedRoleAccess('edit', $member->user_id) ? 'green' : 'red' }} fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName('edit', $member->user_id))
                       ]) }}" data-toggle="tooltip"></i>
                                @endif
                            </label>
                        </td>
                        <td>
                            <label>
                                {!! Form::select("user[$member->user_id][delete]", $actions, $permissionService->selected('user', $member->user_id, 'delete')) !!}
                                @if ($permissionService->inherited('delete', 0, $member->user_id))
                                    <i class="text-{{ $permissionService->inheritedRoleAccess('delete', $member->user_id) ? 'green' : 'red' }} fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName('delete', $member->user_id))
                       ]) }}" data-toggle="tooltip"></i>
                                @endif
                            </label>
                        </td>
                        <td>
                            <label>
                                {!! Form::select("user[$member->user_id][entity-note]", $actions, $permissionService->selected('user', $member->user_id, 'entity-note')) !!}
                                @if ($permissionService->inherited('entity-note', 0, $member->user_id))
                                    <i class="text-{{ $permissionService->inheritedRoleAccess('entity-note', $member->user_id) ? 'green' : 'red' }} fa fa-check-circle" title="{{ __('crud.permissions.inherited_by', [
                           'role' => e($permissionService->inheritedRoleName('entity-note', $member->user_id))
                       ]) }}" data-toggle="tooltip"></i>
                                @endif
                            </label>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>


            @notEnv('shadow')
            {!! Form::hidden('entity_id', $entity->id) !!}

            <div class="form-group">
                <button class="btn btn-success">{{ __('crud.save') }}</button>
            </div>

            {!! Form::close() !!}
            @endif

        </div>
    </div>
@endsection
