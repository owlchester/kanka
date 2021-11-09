<?php
/**
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\CampaignRoleUser[]|\Illuminate\Pagination\LengthAwarePaginator $members
 */
?>
<div class="col-md-12 col-lg-3">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('campaigns.roles.members') }}</h3>
            <div class="box-tools">
                @if (auth()->user()->can('user', $role))
                    <a href="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}"
                       class="btn btn-primary btn-sm"
                       data-toggle="ajax-modal" data-target="#entity-modal"
                       data-url="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}">
                        <i class="fa fa-plus"></i>
                        {{ __('campaigns.roles.users.actions.add') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="users" class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{ __('campaigns.roles.users.fields.name') }}</th>
                        <th><br /></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($members as $relation)
                        <tr>
                            <td>
                                {{ $relation->user->name }}
                                @if (getenv('APP_ENV') === 'local')
                                    ({{ $relation->user->email }})
                                @endif
                            </td>
                            <td class="text-right">
                                @can('removeUser', $role)
                                    <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ __('campaigns.roles.users.actions.remove', ['user' => $relation->user->name, 'role' => $role->name]) }}" data-reset="1"
                                            data-target="#delete-confirm" data-delete-target="campaign-role-member-{{ $relation->id }}"
                                            title="{{ __('crud.remove') }}">
                                        <i class="fa fa-user-slash" aria-hidden="true"></i>
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
                    </tbody>
                </table>
            </div>
        </div>
        @if($members->hasPages())
            <div class="box-footer text-right">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>
