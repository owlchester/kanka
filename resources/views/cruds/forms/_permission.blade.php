@inject('permissionService', 'App\Services\PermissionService')
@php
/**
 * @var \App\Services\PermissionService $permissionService
 * @var \App\Models\CampaignUser $member
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\EntityType $entityType
 */
if (isset($source)) {
    $permissionService->entityPermissions($source);
}
if (isset($entity)) {
    $permissionService->entityPermissions($entity);
    $permissionService->type($entity->type_id);
} else {
    $permissionService->type($entityType->id);
}
$actions = [
    'allow' => __('crud.permissions.actions.bulk_entity.allow'),
    'deny' => __('crud.permissions.actions.bulk_entity.deny'),
    'inherit' => __('crud.permissions.actions.bulk_entity.inherit'),
];

$hidden = false;
if (!empty($source) && $source->is_private) {
    $hidden = true;
} elseif (!empty($model) && $model->is_private) {
    $hidden = true;
}
@endphp

<x-grid type="1/1">
    @can('admin', $campaign)
        @include('cruds.fields.privacy_callout', ['privacyToggle' => true])
    @endif

    <div
        id="entity-is-private"
        x-data="{ show: {{ $hidden ? 'true' : 'false' }} }"
        @entity-privacy-changed.window="show = $event.detail"
        x-show="show">
    <x-alert type="warning" class="rounded-xl">
        <strong>{{ __('entities/permissions.privacy.warning') }}</strong>
        <p>{!! __('entities/permissions.privacy.text', [
        'admin' => '<a href="' . route(
            'campaigns.campaign_roles.admin',
            $campaign,
        ) . '" class="text-link">' .
        $campaign->adminRoleName() . '</a>',
    ]) !!}</p>
    </x-alert>
    </div>

    @include('cruds.permissions.permissions_table', ['skipUsers' => true, 'campaign'])
</x-grid>
