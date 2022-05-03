<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\EntityNote $model
 */
$options = [];
if (isset($bulk)) {
    $options[''] = '';
}

$options['all'] = __('crud.visibilities.all');

if (auth()->user()->isAdmin()) {
    $options['admin'] = __('crud.visibilities.admin');
    $options['members'] = __('crud.visibilities.members');
}
if (!isset($model) || ($model->created_by == auth()->user()->id)) {
    $options['self'] = __('crud.visibilities.self');
    $options['admin-self'] = __('crud.visibilities.admin-self');
}

// If it's a visibility self & admin and we're not the creator, we can't change this
if (isset($model) && $model->visibility === \App\Models\Visibility::VISIBILITY_ADMIN_SELF_STR && $model->created_by !== auth()->user()->id) {
    $options = ['admin-self' => __('crud.visibilities.admin-self')];
}

// The visibility is set to admin but we're not an admin, don't allow changing
// as it's a custom permission for the user to be able to edit this model.
if (isset($model) && in_array($model->visibility, [\App\Models\Visibility::VISIBILITY_ADMIN_STR, \App\Models\Visibility::VISIBILITY_MEMBERS_STR]) && !auth()->user()->isAdmin()) {
    ?><input type="hidden" name="visibility" value="{{ $model->visibility }}" /><?php
    return;
}
?>
<div class="form-group">
    <label for="visibility">
        {{ __('crud.fields.visibility') }}
        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('crud.hints.visibility') }}"></i>
    </label>
    {{ Form::select('visibility', $options, empty($model) ? CampaignLocalization::getCampaign()->default_visibility : $model->visibility, ['class' => 'form-control', 'id' => 'visibility']) }}

    <p class="help-block visible-xs visible-sm">{{ __('crud.hints.visibility') }}</p>
</div>
