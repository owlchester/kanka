@inject('permissionService', 'App\Services\PermissionService')
@php
/**
 * @var \App\Services\PermissionService $permissionService
 * @var \App\Models\CampaignUser $member
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\Campaign $campaign
 */
$permissions = isset($model) ? $permissionService->entityPermissions($model->entity) : [];
if (isset($model)) {
    $permissionService->type($model->entity->type_id);
} else {
    $permissionService->type(config('entities.ids.' . $entityType));
}
$actions = [
    'allow' => __('crud.permissions.actions.bulk_entity.allow'),
    'deny' => __('crud.permissions.actions.bulk_entity.deny'),
    'inherit' => __('crud.permissions.actions.bulk_entity.inherit'),
];

$role = \App\Facades\CampaignCache::adminRole();
@endphp

@includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout', ['privacyToggle' => true])

@php
$hidden = false;
if (!empty($source) && $source->is_private) {
    $hidden = true;
} elseif (!empty($model) && $model->is_private) {
    $hidden = true;
}
@endphp
<div class="alert alert-warning" id="entity-is-private" style="{{ !$hidden ? 'display: none' : null }}">
    <strong>{{ __('entities/permissions.privacy.warning') }}</strong>
    <p>{!! __('entities/permissions.privacy.text', [
    'admin' => link_to_route('campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), CampaignLocalization::getCampaign())
]) !!}</p>
</div>

@include('cruds.permissions.permissions_table', ['skipUsers' => true, 'campaign'])
