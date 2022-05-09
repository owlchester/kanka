<?php
use App\Models\Visibility;
/** @var \App\Models\EntityNote $model */

$icon = "fa-solid fa-" . (in_array($model->visibility, [Visibility::VISIBILITY_SELF_STR, Visibility::VISIBILITY_ADMIN_SELF_STR]) ? 'user-' : '') . 'lock';
if ($model->visibility == Visibility::VISIBILITY_ALL_STR) {
    $icon =  "fa-regular fa-eye";
} elseif ($model->visibility == Visibility::VISIBILITY_MEMBERS_STR) {
    $icon = "fa-solid fa-users";
} elseif ($model->visibility == Visibility::VISIBILITY_SELF_STR) {
    $icon = "fa-solid fa-user-secret";
}

if (isset($toolbox) && $toolbox) {
    $icon .= ' btn-box-tool';
}
if (isset($rightMargin)) {
    $icon .= ' margin-r-5';
}
?>
<i id="element-visibility-{{ $model->id }}" class="{{ $icon }}"
   title="{{ __('crud.visibilities.' . $model->visibility) }}" data-toggle="tooltip"></i>

