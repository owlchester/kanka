<?php
/**
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\CampaignRoleUser[]|\Illuminate\Pagination\LengthAwarePaginator $members
 */
?>
<div class="flex flex-col gap-3">
    <div class="flex items-center justify-between gap-2">
        <h2 class="text-xl font-light">
            {{ __('campaigns.roles.members') }} ({{ $members->total() }})
        </h2>

        @can('user', $role)
            <a href="{{ route('campaign_roles.campaign_role_users.create', [$campaign, 'campaign_role' => $role]) }}"
               class="btn2 btn-primary btn-sm"
               data-toggle="dialog" data-target="new-member"
               data-url="{{ route('campaign_roles.campaign_role_users.create', [$campaign, 'campaign_role' => $role]) }}">
                <x-icon class="plus" />
                {{ __('campaigns.roles.users.actions.add') }}
            </a>
        @endcan
    </div>

    @if ($members->isNotEmpty())
        <div class="flex flex-wrap gap-2">
            @foreach ($members as $relation)
                <div class="bg-base-100 rounded-xl px-3 py-2 shadow-xs flex items-center gap-2.5 max-w-full">
                    <div class="min-w-0 flex flex-col">
                        <span class="truncate text-sm font-medium" data-toggle="tooltip" data-title="{{ $relation->user->name }}">
                            {{ $relation->user->name }}
                        </span>
                        @if (config('app.debug'))
                            <span class="text-neutral-content text-xs truncate">
                                {{ $relation->user->email }}
                            </span>
                        @endif
                    </div>
                    @can('delete', [$relation, $role])
                        <a href="#"
                           class="text-neutral-content hover:text-error transition-colors p-1 -mr-1 rounded-lg"
                           data-toggle="dialog"
                           data-url="{{ route('confirm-delete', [$campaign, 'route' => route('campaign_roles.campaign_role_users.destroy', [$campaign, $role, 'campaign_role_user' => $relation->id]), 'name' => __('campaigns.roles.users.actions.remove', ['user' => $relation->user->name, 'role' => $role->name]), 'permanent' => true]) }}"
                           title="{{ __('campaigns.roles.users.actions.remove_user') }}"
                           aria-label="{{ __('campaigns.roles.users.actions.remove_user') }}">
                            <x-icon class="fa-solid fa-xmark text-sm" />
                        </a>
                    @endcan
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-base-100 rounded-xl p-4 text-sm text-neutral-content shadow-xs">
            {{ __('campaigns.roles.hints.empty_role') }}
        </div>
    @endif

    @if ($members->hasPages())
        <div>
            {{ $members->onEachSide(0)->links() }}
        </div>
    @endif
</div>

@section('modals')
    @parent
    <x-dialog id="new-member" :loading="true" />
@endsection
