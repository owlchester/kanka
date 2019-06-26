<h2 class="page-header with-border">
    {{ trans('campaigns.show.tabs.roles') }}
</h2>

<p class="help-block">{{ trans('campaigns.roles.helper.1') }}</p>
<p class="help-block">{{ trans('campaigns.roles.helper.2') }}</p>
<p class="help-block">{{ trans('campaigns.roles.helper.3') }}</p>

<table id="campaign-roles" class="table table-hover table-striped">
    <tbody><tr>
        <th>{{ trans('campaigns.roles.fields.name') }}</th>
        <th>{{ trans('campaigns.roles.fields.users') }}</th>
        <th>{{ trans('campaigns.roles.fields.type') }}</th>
        <th>{{ trans('campaigns.roles.fields.permissions') }}</th>
        <th>
            @if (Auth::user()->can('update', $campaign))
                <a href="{{ route('campaign_roles.create') }}" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    {{ trans('campaigns.roles.actions.add') }}
                </a>
            @endif</th>
    </tr>
    @foreach ($r = $campaign->roles()
            ->with(['users', 'permissions', 'campaign'])
            ->orderBy('is_admin', 'DESC')
            ->orderBy('is_public', 'DESC')
            ->orderBy('name')
            ->paginate() as $relation)
        <tr>
            <td><a href="{{ route('campaign_roles.show', ['campaign_role' => $relation]) }}">{{ $relation->name }}</a></td>
            <td>{{ $relation->users->count() }}</td>
            <td>{{ trans('campaigns.roles.types.' . ($relation->is_admin ? 'owner' : ($relation->is_public ? 'public' : 'standard'))) }}</td>
            <td>@if ($relation->is_admin)

                @else
                    {{ $relation->permissions->count() }}
            @endif</td>

            <td class="text-right">
                <a href="{{ route('campaign_roles.show', ['campaign_role' => $relation]) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    {{ trans('crud.manage') }}
                </a>
                @can('update', $relation)
                    <a href="{{ route('campaign_roles.edit', ['campaign_role' => $relation]) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        {{ trans('crud.edit') }}
                    </a>
                @endcan
                @can('delete', $relation)
                {!! Form::open(['method' => 'DELETE','route' => ['campaign_roles.destroy', 'campaign_role' => $relation],'style'=>'display:inline']) !!}
                    <button class="btn btn-xs btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->fragment('tab_roles')->links() }}
