<?php
/**
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\CampaignRoleUser[]|\Illuminate\Pagination\LengthAwarePaginator $members
 */
?>
<h3 class="mb-5">
    {{ __('campaigns.roles.members') }}
</h3>

<div class="flex flex-col gap-2">

    @if ($members->isEmpty())
        <x-alert type="info">
            <div class="mb-5">{{__('campaigns.roles.hints.empty_role')}}</div>
        </x-alert>
    @endif

    @can('user', $role)
        <a href="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}"
           class="btn2 btn-primary btn-block"
           data-toggle="ajax-modal" data-target="#entity-modal"
           data-url="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}">
            <x-icon class="plus"></x-icon>
            {{ __('campaigns.roles.users.actions.add') }}
        </a>
    @endcan
    @if ($members->isNotEmpty())
        @foreach ($members as $relation)
            <div class="flex items-center gap-2 rounded bg-box p-2">
                <div class="grow">
                {{ $relation->user->name }}
                @if (config('app.env') === 'local')
                    <br />({{ $relation->user->email }})
                @endif
                </div>
                @can('delete', [$relation, $role])
                    <a href="#" class="btn2 btn-error btn-outline btn-sm delete-confirm" data-toggle="modal" data-name="{{ __('campaigns.roles.users.actions.remove', ['user' => $relation->user->name, 'role' => $role->name]) }}"
                       data-target="#delete-confirm" data-delete-target="campaign-role-member-{{ $relation->id }}"
                       title="{{ __('crud.remove') }}">
                        <i class="fa-solid fa-user-slash" aria-hidden="true" data-toggle="tooltip" title="{{ __('campaigns.roles.users.actions.remove_user') }}"></i>
                    </a>
                @endcan

            </div>
        @endforeach
        @if($members->hasPages())
            <div class="mt-5">
                {{ $members->onEachSide(0)->links() }}
            </div>
        @endif
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
