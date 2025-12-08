<?php
/**
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\CampaignRoleUser[]|\Illuminate\Pagination\LengthAwarePaginator $members
 */
?>
<h2 class="text-xl">
    {{ __('campaigns.roles.members') }} ({{ $members->count() }})
</h2>


<div class="flex flex-wrap gap-2 flex-stretch">
    @if ($members->isNotEmpty())
        @foreach ($members as $relation)
            <div class="flex items-center gap-2 rounded bg-box p-2 w-48 ">
                <div class="grow flex flex-col gap-1 overflow-hidden text-ellipsis">
                    <div class="truncate" data-toggle="tooltip" data-title="{{ $relation->user->name }}">
                        {{ $relation->user->name }}
                    </div>
                @if (config('app.debug'))
                    <span class="text-neutral-content text-xs">
                        {{ $relation->user->email }}
                    </span>
                @endif
                </div>
                @can('delete', [$relation, $role])
                    <a href="#" class="btn2 btn-error btn-outline btn-sm"
                       data-toggle="dialog"
                       data-url="{{ route('confirm-delete', [$campaign, 'route' => route('campaign_roles.campaign_role_users.destroy', [$campaign, $role, 'campaign_role_user' => $relation->id]), 'name' => __('campaigns.roles.users.actions.remove', ['user' => $relation->user->name, 'role' => $role->name]), 'permanent' => true]) }}"
                       title="{{ __('campaigns.roles.users.actions.remove_user') }}">
                        <x-icon class="fa-solid fa-user-slash" />
                    </a>
                @endcan

            </div>
        @endforeach
    @else
        <x-alert type="info grow">
            <div class="">{{__('campaigns.roles.hints.empty_role')}}</div>
        </x-alert>
    @endif
    @can('user', $role)
        <a href="{{ route('campaign_roles.campaign_role_users.create', [$campaign, 'campaign_role' => $role]) }}"
           class="btn2 btn-primary"
           data-toggle="dialog" data-target="new-member"
           data-url="{{ route('campaign_roles.campaign_role_users.create', [$campaign, 'campaign_role' => $role]) }}">
            <x-icon class="plus" />
            {{ __('campaigns.roles.users.actions.add') }}
        </a>
    @endcan
</div>
@if($members->hasPages())
    <div class="">
        {{ $members->onEachSide(0)->links() }}
    </div>
@endif

@section('modals')
    @parent
    <x-dialog id="new-member" :loading="true" />
@endsection
