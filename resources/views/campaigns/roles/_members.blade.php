<?php
/**
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\CampaignRoleUser[]|\Illuminate\Pagination\LengthAwarePaginator $members
 */
?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('campaigns.roles.members') }}</h3>
        <div class="box-tools">
            @can('user', $role)
                <a href="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}"
                   class="btn btn-box-tool"
                   data-toggle="ajax-modal" data-target="#entity-modal"
                   data-url="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    {{ __('campaigns.roles.users.actions.add') }}
                </a>
            @endcan
        </div>
    </div>

    <div class="box-body">
        @forelse ($members as $relation)
            <p>
                @can('delete', [$relation, $role])
                    <a href="#" class="pull-right text-red delete-confirm" data-toggle="modal" data-name="{{ __('campaigns.roles.users.actions.remove', ['user' => $relation->user->name, 'role' => $role->name]) }}"
                            data-target="#delete-confirm" data-delete-target="campaign-role-member-{{ $relation->id }}"
                            title="{{ __('crud.remove') }}">
                        <i class="fa-solid fa-user-slash" aria-hidden="true" data-toggle="tooltip" title="{{ __('campaigns.roles.users.actions.remove_user') }}"></i>
                    </a>
                @endcan

                {{ $relation->user->name }}
                @if (config('app.env') === 'local')
                    <br />({{ $relation->user->email }})
                @endif
            </p>
        @empty
            <div class="alert alert-info">
                <p>{{__('campaigns.roles.hints.empty_role')}}</p>

                @can('user', $role)
                <button href="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}"
                   class="btn btn-default"
                   data-toggle="ajax-modal" data-target="#entity-modal"
                   data-url="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    {{ __('campaigns.roles.users.actions.add') }}
                </button>
                @endcan
            </div>
        @endforelse
    </div>
    @if($members->hasPages())
        <div class="box-footer text-right">
            {{ $members->links() }}
        </div>
    @endif
</div>

@section('modals')
    @parent
    @foreach ($members as $relation)
        @can('delete', [$relation, $role])
        {!! Form::open([
                'method' => 'DELETE', 'route' => ['campaign_roles.campaign_role_users.destroy', 'campaign_role' => $role, 'campaign_role_user' => $relation->id],
                'style' => 'display:inline',
                'id' => 'campaign-role-member-' . $relation->id
            ]) !!}
        {!! Form::close() !!}
        @endcan
    @endforeach
@endsection
