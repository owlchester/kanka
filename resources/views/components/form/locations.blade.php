<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model');
$source = Arr::get($options, 'source');
$quickCreator = Arr::get($options, 'quickCreator', false);

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('locations[]');
$fieldUniqIdentifier = 'locations_' . uniqid();

if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model)) {
    /** @var \App\Models\Location $location */
    foreach ($model->locations as $location) {
        $selectedOption[$location->id] = strip_tags($location->name);
    }
}

if ($quickCreator) {
    $quickCreator = auth()->user()->can('create', new \App\Models\Location());
}
?>
<label>
    {!! \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')) !!}
</label>

@if ($quickCreator)<div class="input-group input-group-sm">@endif

<select multiple="multiple" name="locations[]" class="form-control select2" data-tags="true" style="width: 100%" data-url="{{ route('locations.find') }}" data-allow-clear="true" data-allow-new="false" data-placeholder="" id="{{ $fieldUniqIdentifier }}">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>

@if ($quickCreator)
    <div class="input-group-btn">
        <a class="quick-creator-subform btn btn-tab-form" data-url="{{ route('entity-creator.form', ['type' => 'locations', 'origin' => 'entity-form', 'target' => $fieldUniqIdentifier, 'multi' => true]) }}">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>
</div>
@endif
