<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('campaigns.show.tabs.members') }}
        </h2>

        <p class="help-block">{{ trans('campaigns.members.help') }}</p>

        <table id="campaign-members" class="table table-hover table-striped">
            <tbody><tr>
                <th>{{ trans('campaigns.members.fields.name') }}</th>
                <th>{{ trans('campaigns.members.fields.roles') }}</th>
                <th class="hidden-xs hidden-md">{{ trans('campaigns.members.fields.joined') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r = $campaign->members()->with(['user', 'campaign'])->paginate() as $relation)
                <tr>
                    <td>{{ $relation->user->name }}</td>
                    <td>{{ $relation->user->rolesList($campaign->id) }}</td>
                    <td class="hidden-xs hidden-md">
                        @if (!empty($relation->created_at))
                            <span title="{{ $relation->created_at }}+00:00">{{ $relation->created_at->diffForHumans() }}</span>
                        @endif
                    </td>

                    <td class="text-right">
                        @if (Auth::user()->can('delete', $relation))
                        {!! Form::open(['method' => 'DELETE','route' => ['campaign_users.destroy', $relation->id],'style'=>'display:inline']) !!}
                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs hidden-md">{{ trans('crud.remove') }}</span>
                            </button>
                        {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody></table>

        {{ $r->fragment('tab_member')->links() }}
    </div>
</div>

@if (Auth::user()->can('invite', $campaign))
    <div class="box box-flat">
        <div class="box-body">
            <h2 class="page-header with-border">{{ trans('campaigns.members.invite.title') }}</h2>
            <p class="help-block">
                {{ trans('campaigns.members.invite.description') }}
            </p>

            <table id="campaign-invites" class="table table-hover table-striped">
                <tbody><tr>
                    <th>{{ trans('campaigns.invites.fields.type') }}</th>
                    <th class="hidden-xs hidden-md">{{ trans('campaigns.invites.fields.email') }}</th>
                    <th>{{ trans('campaigns.invites.fields.validity') }}</th>
                    <th>{{ trans('campaigns.invites.fields.role') }}</th>
                    <th class="hidden-xs hidden-md">{{ trans('campaigns.invites.fields.created') }}</th>
                    <th class="text-right">
                        <a href="{{ route('campaign_invites.create', ['type' => 'link']) }}" class="btn btn-primary btn-sm"
                           data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_invites.create', ['type' => 'link']) }}">
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-md">{{ trans('campaigns.invites.actions.link') }}</span>
                        </a>

                        <a href="{{ route('campaign_invites.create') }}" class="btn btn-primary btn-sm"
                        data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_invites.create') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-md">{{ trans('campaigns.invites.actions.add') }}</span>
                        </a>
                    </th>
                </tr>
                @foreach ($r = $campaign->unusedInvites()->with('role')->paginate() as $relation)
                    <tr>
                        <td>{{ trans('campaigns.invites.types.' . $relation->type) }}</td>
                        <td class="hidden-xs hidden-md">@if($relation->type == 'email'){{ $relation->email }}@else<a href="{{ route('campaigns.join', ['token' => $relation->token]) }}">{{ substr($relation->token, 0, 12) . '...' }}</a>@endif</td>
                        <td>{{ $relation->validity }}</td>
                        <td>{{ $relation->role ? $relation->role->name : null }}</td>
                        <td class="hidden-xs hidden-md"><span title="{{ $relation->created_at }}+00:00">{{ $relation->created_at->diffForHumans() }}</span></td>

                        <td class="text-right">
                            {!! Form::open(['method' => 'DELETE','route' => ['campaign_invites.destroy', $relation->id],'style'=>'display:inline']) !!}
                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash" aria-hidden="true"></i> <span  class="hidden-xs hidden-md">{{ trans('crud.remove') }}</span>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody></table>

            {{ $r->fragment('tab_member')->links() }}
        </div>
    </div>
@endif
