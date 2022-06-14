<?php /**
 * @var \App\Models\CampaignUser[] $users
 * @var \App\Models\CampaignRole[] $roles
 */

?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa-solid fa-users"></i> {{ __('campaigns.show.tabs.members') }}
        </h3>
        <div class="box-tools">
            <button class="btn btn-box-tool" data-toggle="dialog"
                    data-target="members-help">
                <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
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
                        <th></th>
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
                                @if ($relation->user->isBanned())
                                    <i class="fa-solid fa-ban" aria-hidden="true" data-toggle="tooltip" title = "{{ __('campaigns.members.fields.banned') }}"></i>
                                @endif
                            </div>
                        </td>
                        <td>
                            {!! $relation->user->rolesList($campaign->id) !!}
                            @can('update', $relation)
                                <i role="button" tabindex="0" class="fa-solid fa-plus-circle cursor btn-user-roles" title="{{ __('campaigns.members.manage_roles') }}" data-content="
                                @foreach($roles as $role)
                                <form method='post' action='{{ route('campaign_users.update-roles', [$relation, $role]) }}' class='user-role-update'>
    {!! str_replace('"', '\'', csrf_field()) !!}

                                    <button class='btn btn-block btn-role-update'>
                                    @if($relation->user->hasCampaignRole($role->id))
                                        <span class='text-danger'><i class='fa-solid fa-times'></i> {{ $role->name }}</span>
                                    @else
                                        <i class='fa-solid fa-plus'></i> {{ $role->name }}
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
                                        <i class="fa-solid fa-ellipsis-h" data-tree="escape"></i>
                                        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        @if (!$relation->user->isBanned())
                                            @can('switch', $relation)
                                                <li>
                                                    <a href="{{ route('identity.switch', $relation) }}" title="{{ __('campaigns.members.helpers.switch') }}" data-toggle="tooltip" class="switch-user">
                                                        <i class="fa-solid fa-sign-in-alt" aria-hidden="true"></i>
                                                        {{ __('campaigns.members.actions.switch') }}
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                            @endcan
                                        @endif
                                        @can('delete', $relation)
                                            <li>
                                                <a href="#" class="text-red delete-confirm" title="{{ __('crud.remove') }}"
                                                   data-toggle="modal" data-name="{{ $relation->user->name }}"
                                                   data-target="#removal-confirm" data-delete-target="campaign-user-{{ $relation->id }}"
                                                >
                                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
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


@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'members-help',
        'title' => __('campaigns.show.tabs.members'),
        'textes' => [
            __('campaigns.members.help'),
            (auth()->check() && auth()->user()->isAdmin() ? __('campaigns.members.helpers.admin', [
        'link' => link_to_route('front.faqs.index', __('front.menu.kb'), null, ['target' => '_blank']),
        'button' => '<code><i class="fa-solid fa-sign-in-alt" aria-hidden="true"></i>' . __('campaigns.members.actions.switch') . '</code>']) : null),
        ]
    ])

    <div class="modal fade" id="removal-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-2xl">
                <div class="modal-body text-center">

                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title" id="myModalLabel">{{ __('crud.delete_modal.title') }}</h4>
                    <p class="mt-3">
                        {!! __('campaigns.members.removal', ['member' => '<strong><span class="target-name"></span></strong>']) !!}<br />
                        <span class="permanent" style="display: none">
                            {{ __('crud.delete_modal.permanent') }}
                        </span>
                    </p>

                    <div class="py-5">
                        <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                        <button type="button" class="btn btn-danger delete-confirm-submit px-8 ml-5 rounded-full">
                            <span class="fa-solid fa-trash"></span>
                            <span class="remove-button-label">{{ __('crud.remove') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
