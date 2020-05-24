<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\EntityNote $model
 */
$options = ['all' => __('crud.visibilities.all')];

if (auth()->user()->isAdmin()) {
    $options['admin'] = __('crud.visibilities.admin');
}
if (!isset($model) || ($model->created_by == auth()->user()->id)) {
    $options['self'] = __('crud.visibilities.self');
    $options['admin-self'] = __('crud.visibilities.admin-self');
}

// If it's a visibility self & admin and we're not the creator, we can't change this
if (isset($model) && $model->visibility === \App\Models\Scopes\VisibilityScope::VISIBILITY_ADMIN_SELF && $model->created_by !== auth()->user()->id) {
    $options = ['admin-self' => __('crud.visibilities.admin-self')];
}
?>
<div class="form-group">
    <label for="visibility">
        {{ trans('crud.fields.visibility') }}
        <i class="fa fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ trans('crud.hints.visibility') }}"></i>
    </label>
    {{ Form::select('visibility', $options, null, ['class' => 'form-control', 'id' => 'visibility']) }}

    <p class="help-block visible-xs visible-sm">{{ trans('crud.hints.visibility') }}</p>
</div>
