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
    $permissionService->entityType($entity->entityType);
} else {
    $permissionService->entityType($entityType);
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
    @include('entities.pages.permissions.table', ['skipUsers' => true, 'campaign'])
</x-grid>
