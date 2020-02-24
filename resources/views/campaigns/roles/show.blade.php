@extends('layouts.app', [
    'title' => trans('campaigns.roles.show.title', ['role' => $role->name, 'campaign' => $model->name]),
    'description' => trans('campaigns.roles.show.description'),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => $role->campaign->name],
        ['url' => route('campaign_roles.index'), 'label' => trans('campaigns.show.tabs.roles')],
        $role->name,
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    @inject('permission', 'App\Services\PermissionService')

    <div class="row">
        @if (!$role->is_public)
        <div class="col-md-12 col-lg-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('campaigns.roles.members') }}</h3>
                </div>

                <div class="box-body">
                    <table id="users" class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ trans('campaigns.roles.users.fields.name') }}</th>
                            <th><br /></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($r = $role->users()->with('user')->paginate() as $relation)
                            <tr>
                                <td>
                                    @if (getenv('APP_ENV') === 'dev')
                                        <span title="{{ $relation->user->email }}">
                                            {{ $relation->user->name }}
                                        </span>
                                    @else
                                        {{ $relation->user->name }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    @can('removeUser', $role)
                                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $relation->user->name }}"
                                        data-target="#delete-confirm" data-delete-target="campaign-role-member-{{ $relation->id }}"
                                        title="{{ trans('crud.remove') }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        {!! Form::open([
                                            'method' => 'DELETE', 'route' => ['campaign_roles.campaign_role_users.destroy', 'campaign_role' => $role, 'campaign_role_user' => $relation->id],
                                            'style' => 'display:inline',
                                            'id' => 'campaign-role-member-' . $relation->id
                                        ]) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody></table>
                    {{ $r->links() }}
                </div>
                    @if (Auth::user()->can('user', $role))
                    <div class="box-footer">
                        <a href="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}" class="btn btn-primary btn-block"
                           data-toggle="ajax-modal" data-target="#entity-modal"
                           data-url="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}">
                            <i class="fa fa-plus"></i>
                            {{ trans('campaigns.roles.users.actions.add') }}
                        </a>
                    </div>
                    @endif
            </div>
        </div>
        @endif

        <div class="col-md-12 col-lg-9">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('crud.permissions.title') }}</h3>
                </div>
                <div class="box-body">
                    <p class="help-block">{{ trans('campaigns.roles.hints.role_permissions', ['name' => $role->name]) }}</p>
                    @if ($role->is_public)
                        <p class="help-block">{!! __('campaigns.roles.hints.public', ['more' => '']) !!}<br />
                            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fas fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
                        </p>
                    @endif

                    @can('permission', $role)
                    {{ Form::open(['route' => ['campaign_roles.savePermissions', 'campaign_role' => $role], 'data-shortcut' => '1']) }}

                        @include('campaigns.roles._pretty')
                    @endif
                </div>
                <div class="box-footer">
                    @can('permission', $role)
                        <div class="form-group">
                            <button class="btn btn-success pull-right">{{ trans('crud.save') }}</button>
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
