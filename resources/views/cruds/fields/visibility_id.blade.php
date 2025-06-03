<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post $model
 */
use App\Enums\Visibility;

$options = [];
if (isset($bulk)) {
    $options[''] = null;
}

$options[Visibility::All->value] = __('crud.visibilities.all');

if (auth()->user()->isAdmin()) {
    $options[Visibility::Admin->value] = __('crud.visibilities.admin');
    $options[Visibility::Member->value] = __('crud.visibilities.members');
}
if (!isset($model) || ($model->created_by == auth()->user()->id)) {
    $options[Visibility::Self->value] = __('crud.visibilities.self');
    $options[Visibility::AdminSelf->value] = __('crud.visibilities.admin-self');
}

// If it's a visibility self & admin, and we're not the creator, we can't change this
if (isset($model) && $model->visibility_id === Visibility::AdminSelf && $model->created_by !== auth()->user()->id) {
    $options = [Visibility::AdminSelf->value => __('crud.visibilities.admin-self')];
}

// The visibility is set to admin, but we're not an admin, don't allow changing
// as it's a custom permission for the user to be able to edit this model.
if (isset($model)) {
    $locked = false;
    // Set to admin but not an admin? An admin created this element, and with custom permissions (like on a post)
    // is allowing a non-admin to edit the post, so we can't have them changing the visibility.
    if ($model->visibility_id === Visibility::Admin && !auth()->user()->isAdmin()) {
        $locked = true;
    }
    // If the visibility is set to self but the user didn't create it, don't allow changing it, as only the person
    // who created is allowed to change the visibility.
    if (in_array($model->visibility_id, [Visibility::Self, Visibility::AdminSelf]) && $model->created_by != auth()->user()->id) {
        $locked = true;
    }
    if ($locked) {
        ?><input type="hidden" name="visibility_id" value="{{ $model->visibility_id }}" /><?php return;
    }
}
$visibilityUniqueID = uniqid('visibility_');
?>
<x-forms.field
    field="visibility"
    label="{{ __('crud.fields.visibility') }}"
    tooltip
    :helper="__('visibilities.tooltip')"
    link="//docs.kanka.io/en/latest/advanced/visibility.html">
    <x-forms.select
        name="visibility_id"
        :options="$options"
        :selected="empty($model) ? (isset($bulk) ? null : $campaign->defaultVisibility()->value) : ($model->visibility_id instanceof Visibility ? $model->visibility_id->value : $model->visibility_id)"
        class="w-full"
        :id="$visibilityUniqueID"
        />
</x-forms.field>
