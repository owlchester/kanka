<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post $model
 * @var \App\Models\Campaign $campaign
 */
use App\Enums\Visibility;

$iconMap = [
    Visibility::All->value => 'fa-regular fa-eye',
    Visibility::Admin->value => 'fa-regular fa-lock',
    Visibility::AdminSelf->value => 'fa-regular fa-user-lock',
    Visibility::Self->value => 'fa-regular fa-user-secret',
    Visibility::Member->value => 'fa-regular fa-users',
];

$visibilitySelected = (int) old('visibility_id', isset($model) && $model->exists
    ? ($model->visibility_id instanceof Visibility ? $model->visibility_id->value : $model->visibility_id)
    : $campaign->defaultVisibility()->value
);

// Locked: admin-only visibility edited by non-admin, or self/admin-self edited by non-creator
if (isset($model) && $model->exists) {
    $locked = false;
    if ($model->visibility_id === Visibility::Admin && !auth()->user()->isAdmin()) {
        $locked = true;
    }
    if (in_array($model->visibility_id, [Visibility::Self, Visibility::AdminSelf]) && $model->created_by != auth()->user()->id) {
        $locked = true;
    }
    if ($locked) {
        $lockedValue = $model->visibility_id instanceof Visibility ? $model->visibility_id->value : $model->visibility_id;
        ?>
        <input type="hidden" name="visibility_id" value="{{ $lockedValue }}" />
        <button class="btn2 btn-default opacity-50 cursor-not-allowed" type="button" disabled>
            <i class="{{ $iconMap[$lockedValue] ?? 'fa-regular fa-eye' }}" aria-hidden="true"></i>
            <span class="sr-only">{{ __('visibilities.title') }}</span>
        </button>
        <?php return;
    }
}

// Build options
if (isset($model) && $model->exists) {
    $visibilityOptions = $model->visibilityOptions();
} else {
    $visibilityOptions = [];
    $visibilityOptions[Visibility::All->value] = __('crud.visibilities.all');
    if (auth()->user()->isAdmin()) {
        $visibilityOptions[Visibility::Admin->value] = __('crud.visibilities.admin');
        $visibilityOptions[Visibility::Member->value] = __('crud.visibilities.members');
    }
    $visibilityOptions[Visibility::Self->value] = __('crud.visibilities.self');
    $visibilityOptions[Visibility::AdminSelf->value] = __('crud.visibilities.admin-self');
}
?>
<x-forms.visibility-picker-field
    :campaign="$campaign"
    :entity-name="$entity->name"
    :options="$visibilityOptions"
    :selected="$visibilitySelected"
/>
