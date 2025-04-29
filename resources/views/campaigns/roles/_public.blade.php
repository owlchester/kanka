<?php
/**
 * @var \App\Services\PermissionService $permissionService
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\EntityType $entityType
 */
?>
<div class="flex flex-col gap-5">
    <div class="flex gap-2">
        <h1 class="grow">
            {{ __('crud.permissions.title') }}
        </h1>
        <div class="flex-none flex gap-2">
            <a href="#" data-url="{{ route('campaign-visibility', $campaign) }}" data-target="campaign-visibility" data-toggle="dialog-ajax" class="btn2 btn-sm btn-primary" >
                <i class="fa-solid fa-user-secret"></i> {{ __('campaigns/roles.actions.status', ['status' => $campaign->isPublic() ? __('campaigns.visibilities.public') : __('campaigns.visibilities.private')]) }}
            </a>

            <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                    data-target="public-help">
                <x-icon class="question" />
                {{ __('general.learn-more') }}
            </button>
        </div>
    </div>

    <x-tutorial code="public_permissions">
        <p>
            {!! __('campaigns/roles.public.description', ['name' => $role->name]) !!}
        </p>

        <p>
            {!! __('campaigns/roles.public.test', [
    'url' => '<a href="' . route('dashboard', $campaign) . '">' . route('dashboard', $campaign) . '</a>']) !!}
        </p>

        <p>
            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i>
                {{ __('helpers.public') }}
            </a>
        </p>
    </x-tutorial>

    <div class="grid gap-5 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @foreach ($modules as $entityType)
            <div class="public-permission flex flex-col gap-2 rounded items-center text-center justify-center break-all overflow-x-hidden cursor-pointer text-lg px-2 py-5 select-none {{ $permissionService->type($entityType->id)->can(\App\Enums\Permission::View) ? "enabled": null }}" data-url="{{ route('campaign_roles.toggle', [$campaign, $role, 'entity' => $entityType->id, 'action' => \App\Enums\Permission::View->value]) }}">
                <div class="block text-2xl">
                    <div class="module-icon">
                        <x-icon class="{{ $entityType->icon() }}" />
                    </div>
                    <div class="loading-animation hidden">
                        <x-icon class="fa-solid fa-spinner fa-spin" />
                    </div>
                </div>

                <div class="">{!! $entityType->plural() !!}</div>
                @if ((!$entityType->isSpecial() && !$campaign->enabled($entityType)) || ($entityType->isSpecial() && !$entityType->isEnabled()))
                    <div class="rounded bg-warning text-warning-content" data-toggle="tooltip" data-title="{{ __('campaigns.modules.permission-disabled') }}">
                        <i class="fa-solid fa-exclamation-triangle"  aria-hidden="true"></i>
                        <span class="md:hidden text-sm inline">{{ __('campaigns.modules.permission-disabled') }}</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

@section('modals')
    @parent

    <x-dialog id="campaign-visibility" :loading="true" />

    @include('partials.helper-modal', [
    'id' => 'public-help',
    'title' => __('campaigns.roles.modals.details.title'),
    'textes' => [
        __('campaigns/roles.public.description', ['name' => $role->name]),
        __('campaigns/roles.public.test', ['url' => '<a href="' . route('dashboard', $campaign) . '">' . route('dashboard', $campaign) . '</a>']),
        '<a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i> ' . __('helpers.public') . '</a>'
]
])
@endsection
