<p class="help-block">{{ trans('campaigns.members.help') }}</p>

<table id="campaign-members" class="table table-hover table-striped">
    <tbody><tr>
        <th>{{ trans('campaigns.members.fields.name') }}</th>
        <th>{{ trans('campaigns.members.fields.roles') }}</th>
        <th>{{ trans('campaigns.members.fields.joined') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $campaign->members()->with(['user'])->paginate() as $relation)
        <tr>
            <td>{{ $relation->user->name }}</td>
            <td>{{ $relation->user->rolesList($campaign->id) }}</td>
            <td>{{ $relation->created_at }}</td>

            <td class="text-right">
                @if (Auth::user()->can('update', $campaign))
                {!! Form::open(['method' => 'DELETE','route' => ['campaign_user.destroy', $relation->id],'style'=>'display:inline']) !!}
                    <button class="btn btn-xs btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_member')->links() }}

@if (Auth::user()->can('invite', $campaign))
    <hr />
    <h3>{{ trans('campaigns.members.invite.title') }}</h3>
    <p class="help-block">
        {{ trans('campaigns.members.invite.description') }}
    </p>

    <table id="campaign-invites" class="table table-hover table-striped">
        <tbody><tr>
            <th>{{ trans('campaigns.invites.fields.email') }}</th>
            <th>{{ trans('campaigns.invites.fields.role') }}</th>
            <th>{{ trans('campaigns.invites.fields.created') }}</th>
            <th>
                <a href="{{ route('campaigns.campaign_invites.create', ['campaign' => $campaign->id]) }}" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    {{ trans('campaigns.invites.actions.add') }}
                </a>
            </th>
        </tr>
        @foreach ($r = $campaign->unusedInvites()->with('role')->paginate() as $relation)
            <tr>
                <td>{{ $relation->email }}</td>
                <td>{{ $relation->role ? $relation->role->name : null }}</td>
                <td>{{ $relation->elapsed('created_at') }}</td>

                <td class="text-right">
                    {!! Form::open(['method' => 'DELETE','route' => ['campaigns.campaign_invites.destroy', $campaign->id, $relation->id],'style'=>'display:inline']) !!}
                    <button class="btn btn-xs btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody></table>

    {{ $r->fragment('tab_member')->links() }}
@endif
