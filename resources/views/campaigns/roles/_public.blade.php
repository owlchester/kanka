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
                <x-icon class="fa-solid fa-user-secret" />
                {{ __('campaigns/roles.actions.status', [
                'status' => $campaign->isUnlisted() ? __('campaigns/visibilities.titles.unlisted') : ($campaign->isPublic() ? __('campaigns/visibilities.titles.public') : __('campaigns/visibilities.titles.private'))
                ]) }}
            </a>
        </div>
    </div>

    <p>
        {!! __('campaigns/roles.public.helpers.intro') !!}
    </p>
    <p>
        {!! __('campaigns/roles.public.helpers.main') !!}
    </p>
    <div class="flex gap-4">
        <a href="{{ route('dashboard', [$campaign, 'goal' => 'incognito']) }}" target="_blank">
            {!! __('campaigns/roles.public.helpers.preview') !!}
            <x-icon class="link" />
        </a>
        <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank">
            {{ __('general.tutorial') }}
            <x-icon class="link" />
        </a>
    </div>

    <h2>
        {{ __('campaigns.show.tabs.modules') }}
    </h2>

    <x-helper>
        <p>{{ __('campaigns/roles.public.helpers.click') }}</p>
    </x-helper>

    <div class="grid gap-5 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @foreach ($modules as $entityType)
            <div class="public-permission flex flex-col gap-2 rounded items-center text-center justify-center break-all overflow-x-hidden cursor-pointer text-lg px-2 py-5 select-none {{ $permissionService->type($entityType->id)->can(\App\Enums\Permission::View) ? "enabled": null }}" data-url="{{ route('campaign_roles.toggle', [$campaign, $role, 'entityType' => $entityType, 'action' => \App\Enums\Permission::View->value]) }}">
                <div class="block text-2xl">
                    <div class="module-icon">
                        <x-icon class="{{ $entityType->icon() }}" />
                    </div>
                    <div class="loading-animation hidden">
                        <x-icon class="load" />
                    </div>
                </div>

                <div class="">{!! $entityType->plural() !!}</div>
                @if (($entityType->isStandard() && !$campaign->enabled($entityType)) || ($entityType->isCustom() && !$entityType->isEnabled()))
                    <div class="rounded bg-warning text-warning-content" data-toggle="tooltip" data-title="{{ __('campaigns.modules.permission-disabled') }}">
                        <x-icon class="fa-regular fa-exclamation-triangle" />
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
@endsection
