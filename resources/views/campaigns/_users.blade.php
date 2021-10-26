<?php /**
 * @var \App\Models\CampaignUser[] $users
 * @var \App\Models\CampaignRole[] $roles
 * @var \App\Models\CampaignInvite[] $invitations
 */

?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-users"></i> {{ __('campaigns.show.tabs.members') }}
        </h3>
        <div class="box-tools">
            <button class="btn btn-default btn-sm" data-toggle="modal"
                    data-target="#members-help">
                <i class="fas fa-question-circle" aria-hidden="true"></i>
                    {{ __('campaigns.members.actions.help') }}
            </button>
        </div>
    </div>

    <div class="box-body no-padding">
        <div class="table-responsive">
            <table id="campaign-members" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>{{ __('campaigns.members.fields.name') }}</th>
                        <th>{{ __('campaigns.members.fields.roles') }}</th>
                        <th class="hidden-xs hidden-md">{{ __('campaigns.members.fields.joined') }}</th>
                        <th class="hidden-xs hidden-md">{{ __('campaigns.members.fields.last_login') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $relation)
                    <tr>
                        <td>
                            <div class="entity-image pull-left" style="background-image: url({{ $relation->user->getAvatarUrl() }})" title="{{ $relation->user->name }}">
                            </div>
                            <div class="user-name text-break">
                                {{ $relation->user->name }}
                            </div>
                        </td>
                        <td>
                            {!! $relation->user->rolesList($campaign->id) !!}
                            @can('update', $relation)
                                <i role="button" tabindex="0" class="fas fa-plus-circle cursor btn-user-roles" title="{{ __('campaigns.members.manage_roles') }}" data-content="
                                @foreach($roles as $role)
                                <form method='post' action='{{ route('campaign_users.update-roles', [$relation, $role]) }}' class='user-role-update'>
    {!! str_replace('"', '\'', csrf_field()) !!}

                                    <button class='btn btn-block btn-role-update'>
                                    @if($relation->user->hasCampaignRole($role->id))
                                        <span class='text-danger'><i class='fas fa-times'></i> {{ $role->name }}</span>
                                    @else
                                        <i class='fas fa-plus'></i> {{ $role->name }}
                                    @endif
                                    </button>
                                </form>
                                @endforeach
    </form>
    "></i>
                            @endcan
                        </td>
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
                            @if(auth()->user()->can('switch', $relation) || auth()->user()->can('delete', $relation))
                                <div class="dropdown">
                                    <a class="dropdown-toggle btn btn-sm btn-default" data-toggle="dropdown" aria-expanded="false" data-placement="right" href="#">
                                        <i class="fa fa-ellipsis-h" data-tree="escape"></i>
                                        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        @can('switch', $relation)
                                            <li>
                                                <a href="{{ route('identity.switch', $relation) }}" title="{{ __('campaigns.members.helpers.switch') }}" data-toggle="tooltip">
                                                    <i class="fa fa-sign-in-alt" aria-hidden="true"></i>
                                                    {{ __('campaigns.members.actions.switch') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('delete', $relation)
                                            <li>
                                                <a href="#" class="text-red delete-confirm" title="{{ __('crud.remove') }}"
                                                   data-toggle="modal" data-name="{{ $relation->user->name }}"
                                                   data-target="#delete-confirm" data-delete-target="campaign-user-{{ $relation->id }}"
                                                >
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                    {{ __('campaigns.members.actions.remove') }}
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                                @can('delete', $relation)
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['campaign_users.destroy', $relation->id],
                                        'style' => 'display:inline',
                                        'id' => 'campaign-user-' . $relation->id]) !!}

                                    {!! Form::close() !!}
                                @endcan
                            @endif
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if ($users->hasPages())
    <div class="box-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>

@if (auth()->user()->can('invite', $campaign))
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('campaigns.members.invite.title') }}
            </h3>
            <div class="box-tools">
                <button class="btn btn-default btn-sm" data-toggle="modal"
                        data-target="#invite-help">
                    <i class="fas fa-question-circle" aria-hidden="true"></i>
                    <span class="hidden-xs hidden-md">{{ __('campaigns.members.actions.help') }}</span>
                </button>

                <a href="{{ route('campaign_invites.create', ['type' => 'link']) }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_invites.create', ['type' => 'link']) }}">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span class="hidden-xs hidden-md">{{ __('campaigns.invites.actions.link') }}</span>
                </a>

                <a href="{{ route('campaign_invites.create') }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_invites.create') }}">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <span class="hidden-xs hidden-md">{{ __('campaigns.invites.actions.add') }}</span>
                </a>
            </div>
        </div>
        @if($invitations->count() > 0)
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table id="campaign-invites" class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('campaigns.invites.fields.type') }}</th>
                        <th class="hidden-xs hidden-sm">{{ __('campaigns.invites.fields.usage') }}</th>
                        <th>{{ __('campaigns.invites.fields.role') }}</th>
                        <th class="hidden-xs hidden-md">{{ __('campaigns.invites.fields.created') }}</th>
                        <th class="text-right">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($invitations as $relation)
                        <tr>
                            <td>
                                @if($relation->type == 'email')<span class="hidden-sm hidden-xs">{{ $relation->email }}</span>
                                @else
                                    <a href="{{ route('campaigns.join', ['token' => $relation->token]) }}">
                                        {{ substr($relation->token, 0, 6) . '...' }}
                                    </a>
                                    <a href="#" title="{{ __('campaigns.invites.actions.copy') }}" data-clipboard="{{ route('campaigns.join', ['token' => $relation->token]) }}" data-toggle="tooltip">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="hidden-xs hidden-sm">
                                {{ $relation->validity !== null ? $relation->validity : __('campaigns.invites.unlimited_validity') }}
                            </td>
                            <td>{{ $relation->role ? $relation->role->name : null }}</td>
                            <td class="hidden-xs hidden-md">
                                <span title="{{ $relation->created_at }}+00:00" data-toggle="tooltip">
                                    {{ $relation->created_at->diffForHumans() }}
                                </span>
                            </td>

                            <td class="text-right">
                                {!! Form::open(['method' => 'DELETE','route' => ['campaign_invites.destroy', $relation->id],'style'=>'display:inline']) !!}
                                <button class="btn btn-xs btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i> <span  class="hidden-xs hidden-md">{{ __('crud.remove') }}</span>
                                </button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </thead>
                </table>
            </div>
        </div>
        @if($invitations->hasPages())
            <div class="box-footer">
                {{ $invitations->links() }}
            </div>
        @endif
        @else
            <div class="box-body">
                <p class="help-block">
                    {!! __('campaigns.members.invite.description') !!}
                </p>
            </div>
        @endif
    </div>
@endif

<div class="modal fade" id="members-help" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    {{ __('campaigns.show.tabs.members') }}
                </h4>
            </div>
            <div class="modal-body">
                <p>{{ __('campaigns.members.help') }}</p>
                @if(auth()->user()->isAdmin())
                <p>
                    {!! __('campaigns.members.helpers.admin', [
        'link' => link_to_route('faq.show', __('front.menu.faq'), ['key' => 'user-switch'], ['target' => '_blank']),
        'button' => '<code><i class="fa fa-sign-in-alt" aria-hidden="true"></i>' . __('campaigns.members.actions.switch') . '</code>']) !!}
                </p>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="invite-help" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    {{ __('campaigns.members.invite.title') }}
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    {{ __('campaigns.members.invite.description') }}
                </p>
                <p>
                    {!! __('campaigns.members.invite.more', [
                        'link' =>
                            '<a href="' . route('campaign_roles.index') . '">'
                            . __('campaigns.members.invite.roles_page') . '</a>'
                    ]) !!}
                </p>
            </div>
        </div>
    </div>
</div>
