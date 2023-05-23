<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$types = \App\Models\EntityType::where('code', '<>', 'menu_link')->orderBy('code')->get();
$options = [];

foreach ($types as $option) {
    $options[] = ['id' => $option->id, 'name' => $option->name];
}

$names = array_column($options, 'name');
array_multisort($names, SORT_ASC, $options);

$showEmpty = Arr::get($options, 'show-empty', true);
$model = Arr::get($options, 'model', null);
$fieldId = 'entity_type_id';
?>

<label>{{ __($label ?? 'crud.fields.entity_type') }}</label>
<select name="{{ $fieldId }}" class="form-control select2-local" style="width: 100%" data-language="{{ LaravelLocalization::getCurrentLocale() }}" data-placeholder="{{ __('colours.none') }}">
    <option value=""></option>
    @foreach ($options as $option)
        <option value="{{ $option['id'] }}" @if ($model && $model->id == $option['id']) selected="selected" @endif>{{ $option['name'] }}</option>
    @endforeach
</select>

