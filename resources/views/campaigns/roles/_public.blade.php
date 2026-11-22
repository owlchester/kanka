<?php
/**
 * @var \App\Services\Permissions\RolePermissionService $permissionService
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 * @var \Illuminate\Support\Collection<int, \App\Models\EntityType> $modules
 */

[$activeModules, $disabledModules] = $modules->partition(
    fn (\App\Models\EntityType $entityType): bool => ($entityType->isStandard() && $campaign->enabled($entityType))
        || ($entityType->isCustom() && $entityType->isEnabled())
);

$visibleActiveCount = $activeModules->filter(
    fn (\App\Models\EntityType $entityType): bool => $permissionService->type($entityType->id)->can(\App\Enums\Permission::View)
)->count();

$anyVisibleCount = $modules->filter(
    fn (\App\Models\EntityType $entityType): bool => $permissionService->type($entityType->id)->can(\App\Enums\Permission::View)
)->count();
?>
<div class="flex flex-col gap-5">
    <x-campaigns.page-header
        :title="__('crud.permissions.title')"
        :lead="__('campaigns/roles.public.helpers.intro')"
    >
        <x-slot name="actions">
            <a href="#" data-url="{{ route('campaign-visibility', $campaign) }}" data-target="campaign-visibility" data-toggle="dialog" class="btn2 btn-sm btn-primary">
                <x-icon class="fa-solid fa-user-secret" />
                {{ __('campaigns/roles.actions.status', [
                    'status' => $campaign->isUnlisted() ? __('campaigns/visibilities.titles.unlisted') : ($campaign->isPublic() ? __('campaigns/visibilities.titles.public') : __('campaigns/visibilities.titles.private'))
                ]) }}
            </a>
            <a href="{{ route('dashboard', [$campaign, 'goal' => 'incognito']) }}" target="_blank" class="btn2 btn-sm">
                <x-icon class="fa-regular fa-eye" />
                {!! __('campaigns/roles.public.helpers.preview') !!}
            </a>
            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank" class="btn2 btn-sm btn-ghost">
                <x-icon class="fa-regular fa-circle-play" />
                {{ __('general.tutorial') }}
            </a>
        </x-slot>
    </x-campaigns.page-header>

    <p class="text-neutral-content">
        {!! __('campaigns/roles.public.helpers.main') !!}
    </p>

    @if ($campaign->isPrivate())
        <x-alert type="info">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="font-semibold">{{ __('campaigns/roles.public.private_notice.title') }}</p>
                    <p class="text-sm opacity-90">{{ __('campaigns/roles.public.private_notice.body') }}</p>
                </div>
                <a href="#" data-url="{{ route('campaign-visibility', $campaign) }}" data-target="campaign-visibility" data-toggle="dialog" class="btn2 btn-sm shrink-0">
                    <x-icon class="fa-solid fa-user-secret" />
                    {{ __('campaigns/roles.public.private_notice.action') }}
                </a>
            </div>
        </x-alert>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-baseline gap-3">
            <h2 class="text-xl font-light">
                {{ __('campaigns/categories.tab') }}
            </h2>
            <span
                class="text-sm text-neutral-content"
                data-public-role-summary
                data-total="{{ $activeModules->count() }}"
                data-template="{{ __('campaigns/roles.public.summary', ['visible' => '__VISIBLE__', 'total' => $activeModules->count()]) }}"
            >
                {{ __('campaigns/roles.public.summary', ['visible' => $visibleActiveCount, 'total' => $activeModules->count()]) }}
            </span>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="button"
                class="btn2 btn-sm"
                data-public-role-bulk="1"
                data-url="{{ route('campaign_roles.toggle-all', [$campaign, $role]) }}"
                @if ($activeModules->isEmpty() || $visibleActiveCount === $activeModules->count()) disabled @endif
            >
                {{ __('campaigns/roles.public.actions.enable_all') }}
            </button>
            <button
                type="button"
                class="btn2 btn-sm btn-ghost"
                data-public-role-bulk="0"
                data-url="{{ route('campaign_roles.toggle-all', [$campaign, $role]) }}"
                @if ($anyVisibleCount === 0) disabled @endif
            >
                {{ __('campaigns/roles.public.actions.disable_all') }}
            </button>
        </div>
    </div>

    <div class="grid gap-3 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($activeModules as $entityType)
            @include('campaigns.roles._public_card', [
                'campaign' => $campaign,
                'role' => $role,
                'entityType' => $entityType,
                'enabled' => $permissionService->type($entityType->id)->can(\App\Enums\Permission::View),
                'isDisabled' => false,
            ])
        @endforeach
    </div>

    @if ($disabledModules->isNotEmpty())
        <details class="group/disabled">
            <summary class="list-none cursor-pointer flex items-center gap-2 text-sm text-neutral-content hover:text-base-content select-none py-1">
                <x-icon class="fa-solid fa-chevron-right text-xs transition-transform group-open/disabled:rotate-90" />
                <span>{{ __('campaigns/roles.public.disabled_categories.title', ['count' => $disabledModules->count()]) }}</span>
            </summary>
            <div class="mt-3 flex flex-col gap-3">
                <p class="text-sm text-neutral-content">
                    {{ __('campaigns/roles.public.disabled_categories.helper') }}
                </p>
                <div class="grid gap-3 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($disabledModules as $entityType)
                        @include('campaigns.roles._public_card', [
                            'campaign' => $campaign,
                            'role' => $role,
                            'entityType' => $entityType,
                            'enabled' => $permissionService->type($entityType->id)->can(\App\Enums\Permission::View),
                            'isDisabled' => true,
                        ])
                    @endforeach
                </div>
            </div>
        </details>
    @endif
</div>

@section('modals')
    @parent

    <x-dialog id="campaign-visibility" :loading="true" />
@endsection
