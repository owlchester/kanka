<?php
if ($model->visibility == \App\Models\Scopes\VisibilityScope::VISIBILITY_ALL) {
    return;
}

$icon = $model->visibility == \App\Models\Scopes\VisibilityScope::VISIBILITY_SELF ? 'user-' : '';
?>

<i class="fas fa-{{ $icon }}lock" title="{{ __('crud.visibilities.' . $model->visibility) }}"></i>