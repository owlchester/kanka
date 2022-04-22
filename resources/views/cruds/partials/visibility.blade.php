<?php
use App\Models\Scopes\VisibilityScope;
/** @var \App\Models\EntityNote $model */

$icon = "fa-solid fa-" . (in_array($model->visibility, [VisibilityScope::VISIBILITY_SELF, VisibilityScope::VISIBILITY_ADMIN_SELF]) ? 'user-' : '') . 'lock';
if ($model->visibility == \App\Models\Scopes\VisibilityScope::VISIBILITY_ALL) {
    $icon =  "fa-regular fa-eye";
} elseif ($model->visibility == VisibilityScope::VISIBILITY_MEMBERS) {
    $icon = "fa-solid fa-users";
} elseif ($model->visibility == VisibilityScope::VISIBILITY_SELF) {
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

