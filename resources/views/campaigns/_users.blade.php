<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('campaigns.show.tabs.members') }}
        </h2>

        <p class="help-block">
            {{ __('campaigns.members.help') }}
            {!! __('campaigns.members.helpers.admin', ['link' => link_to_route('faq.show', __('front.menu.faq'), ['key' => 'user-switch'], ['target' => '_blank'])]) !!}
        </p>

        <table id="campaign-members" class="table table-hover table-striped">
            <tbody><tr>
                <th>{{ __('campaigns.members.fields.name') }}</th>
                <th>{{ __('campaigns.members.fields.roles') }}</th>
                <th class="hidden-xs hidden-md">{{ __('campaigns.members.fields.joined') }}</th>
                <th class="hidden-xs hidden-md">{{ __('campaigns.members.fields.last_login') }}</th>
                <th>&nbsp;</th>
            </tr>
            <?php /** @var \App\Models\CampaignUser $relation */?>
            @foreach ($r = $campaign->members()->with(['user', 'campaign', 'user.campaignRoles'])->paginate() as $relation)
                <tr>
                    <td>
                        <div class="entity-image float-left" style="background-image: url({{ $relation->user->getAvatarUrl() }})" title="{{ $relation->user->name }}">
                        </div>
                        <div class="entity-name-img">{{ $relation->user->name }}</div>
                    </td>
                    <td>{{ $relation->user->rolesList($campaign->id) }}</td>
                    <td class="hidden-xs hidden-md">
                        @if (!empty($relation->created_at))
                            <span title="{{ $relation->created_at }}+00:00">{{ $relation->created_at->diffForHumans() }}</span>
                        @endif
                    </td>
                    <td class="hidden-xs hidden-md">
                        @if ($relation->user->has_last_login_sharing && !empty($relation->user->last_login_at))
                            <span title="{{ $relation->user->last_login_at }}+00:00">{{ $relation->user->last_login_at->diffForHumans() }}</span>
                        @endif
                    </td>

                    <td class="text-right">
                    @can('switch', $relation)
                        <a href="{{ route('identity.switch', $relation) }}" class="btn btn-default btn-xs" title="{{ __('campaigns.members.helpers.switch') }}">
                            <i class="fa fa-user"></i> <span class="hidden-xs hidden-md">{{ __('campaigns.members.actions.switch') }}</span>
                        </a>
                    @endcan
                    @can('delete', $relation)
                        <button class="btn btn-xs btn-danger delete-confirm"
                                data-toggle="modal" data-name="{{ $relation->user->name }}"
                                data-target="#delete-confirm" data-delete-target="campaign-user-{{ $relation->id }}"
                        >
                            <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs hidden-md">{{ __('crud.remove') }}</span>
                        </button>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['campaign_users.destroy', $relation->id],
                            'style' => 'display:inline',
                            'id' => 'campaign-user-' . $relation->id]) !!}

                        {!! Form::close() !!}
                    @endcan
                    </td>
                </tr>
            @endforeach
            </tbody></table>

        {{ $r->links() }}
    </div>
</div>

@if (Auth::user()->can('invite', $campaign))
    <div class="box box-solid">
        <div class="box-body">
            <h2 class="page-header with-border">{{ __('campaigns.members.invite.title') }}</h2>
            <p class="help-block">
                {{ __('campaigns.members.invite.description') }}
                {!! __('campaigns.members.invite.more', [
                    'link' =>
                        '<a href="' . route('campaign_roles.index') . '">'
                        . __('campaigns.members.invite.roles_page') . '</a>'
                ]) !!}
            </p>

            <table id="campaign-invites" class="table table-hover table-striped">
                <tbody><tr>
                    <th>{{ __('campaigns.invites.fields.type') }}</th>
                    <th>{{ __('campaigns.invites.fields.email') }}</th>
                    <th>{{ __('campaigns.invites.fields.validity') }}</th>
                    <th>{{ __('campaigns.invites.fields.role') }}</th>
                    <th class="hidden-xs hidden-md">{{ __('campaigns.invites.fields.created') }}</th>
                    <th class="text-right">
                        <a href="{{ route('campaign_invites.create', ['type' => 'link']) }}" class="btn btn-primary btn-sm"
                           data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_invites.create', ['type' => 'link']) }}">
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-md">{{ __('campaigns.invites.actions.link') }}</span>
                        </a>

                        <a href="{{ route('campaign_invites.create') }}" class="btn btn-primary btn-sm"
                        data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_invites.create') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-md">{{ __('campaigns.invites.actions.add') }}</span>
                        </a>
                    </th>
                </tr>
                @foreach ($r = $campaign->unusedInvites()->with('role')->paginate() as $relation)
                    <tr>
                        <td>{{ __('campaigns.invites.types.' . $relation->type) }}</td>
                        <td>
                            @if($relation->type == 'email')<span class="hidden-sm hidden-xs">{{ $relation->email }}</span>
                            @else
                                <a href="{{ route('campaigns.join', ['token' => $relation->token]) }}" class="hidden-sm hidden-xs">
                                    {{ substr($relation->token, 0, 6) . '...' }}
                                </a>
                                <a href="#" title="{{ __('campaigns.invites.actions.copy') }}" data-clipboard="{{ route('campaigns.join', ['token' => $relation->token]) }}" data-toggle="tooltip">
                                    <i class="fa fa-copy"></i>
                                </a>
                            @endif
                        </td>
                        <td
                        <td>{{ $relation->validity !== null ? $relation->validity : __('campaigns.invites.unlimited_validity') }}</td>
                        <td>{{ $relation->role ? $relation->role->name : null }}</td>
                        <td class="hidden-xs hidden-md"><span title="{{ $relation->created_at }}+00:00">{{ $relation->created_at->diffForHumans() }}</span></td>

                        <td class="text-right">
                            {!! Form::open(['method' => 'DELETE','route' => ['campaign_invites.destroy', $relation->id],'style'=>'display:inline']) !!}
                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash" aria-hidden="true"></i> <span  class="hidden-xs hidden-md">{{ __('crud.remove') }}</span>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody></table>

            {{ $r->links() }}
        </div>
    </div>
@endif
