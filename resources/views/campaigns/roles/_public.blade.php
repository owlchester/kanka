<?php
/**
 * @var \App\Services\PermissionService $permission
 * @var \App\Services\EntityService $entity
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 */
$permission->role($role);
?>
<div class="flex flex-col gap-5">

<h1 class="">
    <div class="pull-right">
        <a href="#" data-url="{{ route('campaign-visibility', $campaign) }}" data-target="campaign-visibility" data-toggle="dialog-ajax" class="btn2 btn-sm btn-primary" >
            <i class="fa-solid fa-user-secret"></i> {{ __('campaigns/roles.actions.status', ['status' => $campaign->isPublic() ? __('campaigns.visibilities.public') : __('campaigns.visibilities.private')]) }}
        </a>

        <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                data-target="public-help">
            <x-icon class="question"></x-icon>
            {!! __('crud.actions.help') !!}
        </button>
    </div>
    {{ __('crud.permissions.title') }}
</h1>

<x-tutorial code="public_permissions">
    <p>
        {!! __('campaigns/roles.public.description', ['name' => $role->name]) !!}
    </p>

    <p>
        {!! __('campaigns/roles.public.test', [
'url' => link_to_route('dashboard', null, $campaign)]) !!}
    </p>

    <p>
        <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i>
            {{ __('helpers.public') }}
        </a>
    </p>
</x-tutorial>

<div class="grid gap-5 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
    @foreach ($permission->entityTypes() as $name => $id)
        <div class="public-permission flex rounded items-center text-center justify-center break-all cursor-pointer text-xl px-2 py-5 {{ $permission->type($id)->can() ? "enabled": null }}" data-url="{{ route('campaign_roles.toggle', [$campaign, $role, 'entity' => $id, 'action' => \App\Models\CampaignPermission::ACTION_READ]) }}">
            <i class="entity-type-icon block text-2xl {{ EntitySetup::icon($id) }} mb-2" aria-hidden="true"></i>

            <div>{{ EntitySetup::plural($id) }}</div>
            @if (!$campaign->enabled(\Illuminate\Support\Str::plural($name)))
                <div class="mt-2 w-full rounded bg-warning text-danger" data-toggle="tooltip" data-title="{{ __('campaigns.modules.permission-disabled') }}">
                    <i class="fa-solid fa-exclamation-triangle"  aria-hidden="true"></i>
                    <span class="visible-xs visible-sm text-sm inline">{{ __('campaigns.modules.permission-disabled') }}</span>
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
        __('campaigns/roles.public.test', ['url' => link_to_route('dashboard', null, $campaign)]),
        '<a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i> ' . __('helpers.public') . '</a>'
]
])
@endsection
