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
    {{ Form::select('visibility', $options, null, ['class' => 'form-control', 'id' => 'visibility']) }}
    <p class="help-block">{{ trans('crud.hints.visibility') }}</p>
</div>