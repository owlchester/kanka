<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$types = \App\Models\EntityType::inCampaign($campaign)->where('code', '<>', 'bookmark')->orderBy('code')->get();
$entityTypes = [];

foreach ($types as $option) {
    $entityTypes[] = ['id' => $option->id, 'name' => $option->name];
}

$names = array_column($entityTypes, 'name');
array_multisort($names, SORT_ASC, $entityTypes);

$showEmpty = Arr::get($options, 'show-empty', true);
$model = Arr::get($options, 'model', null);
$fieldId = 'entity_type_id';
?>

<label>{{ __($label ?? 'campaigns/categories.tab') }}</label>
<select name="{{ $fieldId }}" class="w-full select2-local" style="width: 100%" data-language="{{ LaravelLocalization::getCurrentLocale() }}" data-placeholder="{{ __('colours.none') }}">
    <option value=""></option>
    @foreach ($entityTypes as $option)
        <option value="{{ $option['id'] }}" @if ($model && $model->id == $option['id']) selected="selected" @endif>{{ $option['name'] }}</option>
    @endforeach
</select>

