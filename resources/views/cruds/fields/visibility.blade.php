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
}
?>
<div class="form-group">
    <label for="visibility">
        {{ trans('crud.fields.visibility') }}
    </label>
    <i class="fa fa-question-circle pull-right hidden-xs hidden-sm" data-toggle="tooltip" title="{{ trans('crud.hints.visibility') }}"></i>
    {{ Form::select('visibility', $options, null, ['class' => 'form-control', 'id' => 'visibility']) }}

    <p class="help-block visible-xs visible-sm">{{ trans('crud.hints.visibility') }}</p>
</div>