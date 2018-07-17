@extends('layouts.app', [
    'title' => trans('campaigns.roles.show.title', ['role' => $role->name, 'campaign' => $model->name]),
    'description' => trans('campaigns.roles.show.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index', ['#tab_roles']), 'label' => trans('campaigns.index.title')]
    ]
])

@section('content')
    @include('partials.errors')
    @inject('permission', 'App\Services\PermissionService')

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('campaigns.roles.members') }}</h3>
                </div>
                <div class="box-body">
                    @if (Auth::user()->can('user', $role))
                        <p class="text-right">
                            <a href="{{ route('campaigns.campaign_roles.campaign_role_users.create', ['campaign' => $model, 'campaign_role' => $role]) }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                                {{ trans('campaigns.roles.users.actions.add') }}
                            </a>
                        </p>
                    @endif
                    <table id="users" class="table table-hover">
                        <tbody><tr>
                            <th>{{ trans('campaigns.roles.users.fields.name') }}</th>
                            <th><br /></th>
                        </tr>
                        @foreach ($r = $role->users()->with('user')->paginate() as $relation)
                            <tr>
                                <td>{{ $relation->user->name }}</td>
                                <td class="text-right">
                                    @can('removeUser', $role)
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['campaigns.campaign_roles.campaign_role_users.destroy', 'campaign' => $model, 'campaign_role' => $role, 'campaign_role_user' => $relation->id], 'style'=>'display:inline']) !!}
                                        <button class="btn btn-xs btn-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                                        </button>
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody></table>
                    {{ $r->links() }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('crud.permissions.title') }}</h3>
                </div>
                <div class="box-body">
                    <p class="help-block">{{ trans('campaigns.roles.hints.role_permissions', ['name' => $role->name]) }}</p>

                    @can('permission', $role)
                    {{ Form::open(['route' => ['campaigns.campaign_roles.savePermissions', 'campaign' => $model, 'campaign_role' => $role], 'data-shortcut' => '1']) }}
                    <table id="permissions" class="table table-hover">
                        <tbody><tr>
                            <th>{{ trans('crud.fields.entity') }}</th>
                            <th>{{ trans('crud.permissions.action') }}</th>
                            <th>{{ trans('crud.permissions.allowed') }}</th>
                            <th><br /></th>
                        </tr>
                        @foreach ($permission->permissions($role) as $permission)
                            <tr {{ ($permission['action'] == 'permission' ? 'class="danger"' : null)  }}>
                                <td>{{ trans('entities.' . $permission['entity']) }}</td>
                                <td>{{ trans('campaigns.roles.permissions.actions.' . $permission['action']) }}</td>
                                <td>{!! Form::checkbox('permissions[' . $permission['key'] . ']', $permission['entity'], $permission['enabled']) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        <button class="btn btn-success">{{ trans('crud.save') }}</button>
                    </div>
                    {{ Form::close() }}
                    @else
                        <p>{{ trans('campaigns.roles.permissions.hint') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
