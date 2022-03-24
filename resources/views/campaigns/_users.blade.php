<?php /**
 * @var \App\Models\CampaignUser[] $users
 * @var \App\Models\CampaignRole[] $roles
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
                                <a href="{{ route('users.profile', $relation->user_id) }}" target="_blank">
                                    {{ $relation->user->name }}
                                </a>
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
    <div class="box-footer text-right">
        {{ $users->links() }}
    </div>
    @endif
</div>

@include('campaigns._invites')

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

