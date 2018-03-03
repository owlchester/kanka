@if (Auth::user()->can('update', $campaign))
    <p class="text-right">
        <a href="{{ route('campaigns.campaign_roles.create', ['campaign' => $campaign]) }}" class="btn btn-primary">
            {{ trans('campaigns.roles.actions.add') }}
        </a>
    </p>
@endif

<table id="campaigns" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('campaigns.roles.fields.name') }}</th>
        <th>{{ trans('campaigns.roles.fields.users') }}</th>
        <th>{{ trans('campaigns.roles.fields.permissions') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $campaign->roles()->with('users')->paginate() as $relation)
        <tr>
            <td><a href="{{ route('campaigns.campaign_roles.show', ['campaign' => $campaign, 'campaign_role' => $relation]) }}">{{ $relation->name }}</a></td>
            <td>{{ $relation->users()->count() }}</td>
            <td>{{ $relation->permissions()->count() }}</td>

            <td class="text-right">
                @if (Auth::user()->can('update', $relation))
                    <a href="{{ route('campaigns.campaign_roles.edit', ['campaign' => $campaign, 'campaign_role' => $relation]) }}" class="btn btn-xs btn-primary">{{ trans('crud.edit') }}</a>
                @endif
                @if (Auth::user()->can('delete', $relation))
                {!! Form::open(['method' => 'DELETE','route' => ['campaigns.campaign_roles.destroy', 'campaign' => $campaign, 'campaign_role' => $relation],'style'=>'display:inline']) !!}
                    <button class="btn btn-xs btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->appends('tab', 'roles')->links() }}
