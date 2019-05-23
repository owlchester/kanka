<?php
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$types = \App\Models\EntityType::all();

$showEmpty = array_get($options, 'show-empty', true);
$model = array_get($options, 'model', null);
?>

<label>{{ trans('crud.fields.entity_type') }}</label>
<select name="{{ $fieldId }}" class="form-control select2-local" style="width: 100%" data-language="{{ LaravelLocalization::getCurrentLocale() }}" data-placeholder="{{ __('colours.none') }}">
    <option value=""></option>
    @foreach ($types as $option)
        <option value="{{ $option->id }}" @if ($model && $model->id == $option->id) selected="selected" @endif>{{ $option->name() }}</option>
    @endforeach
</select>

