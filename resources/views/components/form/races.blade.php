<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model');
$quickCreator = Arr::get($options, 'quickCreator', false);

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('races[]');
$fieldUniqIdentifier = 'races_' . uniqid();

if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model)) {
    /** @var \App\Models\Race $race */
    foreach ($model->races as $race) {
        $selectedOption[$race->id] = strip_tags($race->name);
    }
}

if ($quickCreator) {
    $quickCreator = auth()->user()->can('create', new \App\Models\Race());
}
?>
<label>{{ \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races')) }}</label>

@if ($quickCreator)<div class="input-group input-group-sm">@endif

<select multiple="multiple" name="races[]" class="form-control select2" data-tags="true" style="width: 100%" data-url="{{ route('races.find') }}" data-allow-clear="true" data-allow-new="false" data-placeholder="" id="{{ $fieldUniqIdentifier }}">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>

@if ($quickCreator)
        <div class="input-group-btn">
            <a class="quick-creator-subform btn btn-tab-form" data-url="{{ route('entity-creator.form', ['type' => 'races', 'origin' => 'entity-form', 'target' => $fieldUniqIdentifier, 'multi' => true]) }}">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
    </div>
@endif
