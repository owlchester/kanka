<?php
/**
 * @var \App\Services\PermissionService $permission
 * @var \App\Services\EntityService $entity
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 */
$permission->role($role);
?>
<h1 class="mb-2 mt-0">
    <div class="pull-right">
        <a href="#" data-url="{{ route('campaign-visibility') }}" data-target="#entity-modal" data-toggle="ajax-modal" class="btn btn-primary" >
            <i class="fa-solid fa-user-secret"></i> {{ __('campaigns/roles.actions.status', ['status' => $campaign->isPublic() ? __('campaigns.visibilities.public') : __('campaigns.visibilities.private')]) }}
        </a>

        <button class="btn btn-default" data-toggle="dialog"
                data-target="public-help">
            <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
            {!! __('campaigns.members.actions.help') !!}
        </button>
    </div>
    {{ __('crud.permissions.title') }}
</h1>

@if (auth()->check() && !auth()->user()->settings()->get('tutorial_public_permissions'))
    <div class="alert alert-info tutorial">
        <button type="button" class="close banner-notification-dismiss" data-dismiss="alert" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => 'public_permissions', 'type' => 'tutorial']) }}">×</button>

        <p class="mb-5">
            {!! __('campaigns/roles.public.description', ['name' => $role->name]) !!}
        </p>

        <p class="mb-5">
            {!! __('campaigns/roles.public.test', [
    'url' => link_to_route('dashboard')]) !!}
        </p>

        <p class="mb-5">
            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i>
                {{ __('helpers.public') }}
            </a>
        </p>
    </div>
@endif

<div class="grid gap-2 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
    @foreach ($permission->entityTypes() as $name => $id)
        <div class="public-permission rounded cursor px-2 py-5 {{ $permission->type($id)->can() ? "enabled": null }}" data-url="{{ route('campaign_roles.toggle', [$role, 'entity' => $id, 'action' => \App\Models\CampaignPermission::ACTION_READ]) }}">
            <i class="entity-type-icon {{ EntitySetup::icon($id) }} mb-2" aria-hidden="true"></i>

            <div>{{ EntitySetup::plural($id) }}</div>
            @if (!$campaign->enabled(\Illuminate\Support\Str::plural($name)))
                <div class="mt-2 w-full rounded bg-warning text-danger" data-toggle="tooltip" title="{{ __('campaigns.modules.permission-disabled') }}">
                    <i class="fa-solid fa-exclamation-triangle"  aria-hidden="true"></i>
                    <span class="visible-xs visible-sm text-sm inline">{{ __('campaigns.modules.permission-disabled') }}</span>
                </div>
            @endif
        </div>
    @endforeach
</div>

@section('modals')
    @parent

    @include('partials.helper-modal', [
    'id' => 'public-help',
    'title' => __('campaigns.roles.modals.details.title'),
    'textes' => [
        __('campaigns/roles.public.description', ['name' => $role->name]),
        __('campaigns/roles.public.test', ['url' => link_to_route('dashboard')]),
        '<a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i> ' . __('helpers.public') . '</a>'
]
])
@endsection
