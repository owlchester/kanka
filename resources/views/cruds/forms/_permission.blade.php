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
if (isset($model)) {
    if ($model instanceof \App\Models\Entity) {
        $permissionService->entityPermissions($model);
        $permissionService->type($model->type_id);
    } else {
        $permissionService->entityPermissions($model->entity);
        $permissionService->type($model->entity->type_id);
    }
} elseif (isset($entity)) {
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

$role = \App\Facades\CampaignCache::adminRole();
$hidden = false;
if (!empty($source) && $source->is_private) {
    $hidden = true;
} elseif (!empty($model) && $model->is_private) {
    $hidden = true;
}
@endphp

<x-grid type="1/1">
    @includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout', ['privacyToggle' => true])

    <x-alert type="warning" id="entity-is-private" :hidden="!$hidden">
        <strong>{{ __('entities/permissions.privacy.warning') }}</strong>
        <p>{!! __('entities/permissions.privacy.text', [
        'admin' => '<a href="' . route(
            'campaigns.campaign_roles.admin',
            $campaign,
        ) . '" target="_blank">' .
        \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')) . '</a>',
    ]) !!}</p>
    </x-alert>

    @include('cruds.permissions.permissions_table', ['skipUsers' => true, 'campaign'])
</x-grid>
