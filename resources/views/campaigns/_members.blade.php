<table id="campaigns" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('campaigns.members.fields.name') }}</th>
        <th>{{ trans('campaigns.members.fields.role') }}</th>
        <th>{{ trans('campaigns.members.fields.joined') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $campaign->members()->with('user')->paginate() as $relation)
        <tr>
            <td>{{ $relation->user->name }}</td>
            <td>{{ $relation->role }}</td>
            <td>{{ $relation->created_at }}</td>

            <td class="text-right">
                @if ($campaign->owner() && $relation->role != 'owner')
                    <a href="{{ route('campaign_user.edit', $relation->id) }}" class="btn btn-xs btn-primary">{{ trans('crud.edit') }}</a>
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

{{ $r->appends('tab', 'member')->links() }}

@if ($campaign->member() || $campaign->owner())
<hr />
<h3>{{ trans('campaigns.members.invite.title') }}</h3>
<p>
    {{ trans('campaigns.members.invite.description') }}
</p>
<p>{{ route('campaigns.join', ['token' => $campaign->join_token]) }}</p>
@endif
