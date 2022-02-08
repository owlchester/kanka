<?php
use Illuminate\Support\Arr;
/**
 * @var array $options
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$prefill = Arr::get($options, 'preset');
$prefillModel = Arr::get($options, 'class');
$allowNew = Arr::get($options, 'allowNew', false);
$quickCreator = Arr::get($options, 'quickCreator', false);
$labelKey = Arr::get($options, 'labelKey');
$searchParams = Arr::get($options, 'searchParams');
$searchRouteName = Arr::get($options, 'searchRouteName');
$placeholderKey = Arr::get($options, 'placeholderKey');
$from = Arr::get($options, 'from');
$allowClear = Arr::get($options, 'allowClear', true);
$dropdownParent = Arr::get($options, 'dropdownParent');

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old($fieldId);
if (!empty($previous) && !empty($prefillModel)) {
    // Previous input has a value, load that one
    $selectedModel = new $prefillModel;
    $selected = $selectedModel->find($previous);
    if ($selected) {
        $selectedOption = [$selected->id => $selected->name];
    }
}
// If we didn't get anything, and there is a model sent, use that
if (empty($selectedOption) && !empty($prefill)) {
    if ($prefill instanceof \App\Models\MiscModel) {
        $selectedOption = [$prefill->id => $prefill->name];
    } elseif ($prefill instanceof \App\Models\Entity) {
        $selectedOption = [$prefill->id => $prefill->name];
    } elseif ($prefill instanceof \App\Models\Image) {
        $selectedOption = [$prefill->id => $prefill->name];
    } elseif ($prefill instanceof \App\Models\MapMarker) {
        $selectedOption = [$prefill->id => $prefill->name];
    } elseif (is_array($prefill)) {
        $selectedOption = $prefill;
    }
}

// Assume placeholder key
$singularFieldName = str_replace('_id', '', $fieldId);
$pluralField = \Illuminate\Support\Str::plural($singularFieldName);
if ($pluralField == 'parent_locations') {
    $pluralField = 'locations';
}
$placeholderKey = empty($placeholderKey) ? 'crud.placeholders.' . $singularFieldName : $placeholderKey;
$labelKey = empty($labelKey) ? 'crud.fields.' . $singularFieldName : $labelKey;
$searchRouteName = empty($searchRouteName) ? $pluralField . '.find' : $searchRouteName;

// Check for permissions
if ($allowNew) {
    $allowNew = auth()->user()->can('create', new $prefillModel);
}

//initialise to empty array if empty
if(empty($searchParams)){
    $searchParams = [];
}
// From source to exclude duplicates
if (!empty($from)) {
    $searchParams['exclude'] = $from->id;
}

$fieldUniqIdentifier = $fieldId . '_' . uniqid();
?>
<label>{{ __($labelKey) }}</label>

@if ($allowNew || !empty($quickCreator))
    <div class="input-group input-group-sm">
@endif

{!! Form::select(
    $fieldId,
    $selectedOption,
    [],
    [
        'id' => $fieldUniqIdentifier,
        'class' => 'form-control select2',
        'style' => 'width: 100%',
        'data-url' => route($searchRouteName, $searchParams),
        'data-placeholder' => __($placeholderKey),
        'data-language' => LaravelLocalization::getCurrentLocale(),
        'data-allow-clear' => $allowClear ? 'true' : 'false',
        'from' => null,
        'data-dropdown-parent' => $dropdownParent ?: null,
    ],
) !!}

@if ($allowNew)
    <div class="input-group-btn">
        <a class="new-entity-selector btn btn-tab-form" style="" data-toggle="modal" data-target="#new-entity-modal" data-parent="{{ $fieldUniqIdentifier }}" data-entity="{{ $pluralField }}">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>
</div>
@elseif(!empty($quickCreator))
    <div class="input-group-btn">
        <a class="quick-creator-subform btn btn-tab-form" data-url="{{ route('entity-creator.form', ['type' => $pluralField, 'origin' => 'entity-form', 'target' => $fieldUniqIdentifier]) }}">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>
    </div>
@endif
