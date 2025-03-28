<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model');
$source = Arr::get($options, 'source');
$quickCreator = Arr::get($options, 'quickCreator', false);
$dynamicNew = Arr::get($options, 'dynamicNew', false);

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
    $quickCreator = auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $campaign]);
}
?>

<x-forms.field
    field="locations"
    :label="\App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations'))">


<select multiple="multiple" name="locations[]" class="w-full select2 join-item" data-tags="true" style="width: 100%" data-url="{{ route('search-list', [$campaign, config('entities.ids.location')]) }}" data-allow-clear="true" data-new-tag="{{ __('crud.actions.new') }}" data-allow-new="{{ $dynamicNew ? 'true' : false}}" data-placeholder="{{ __('crud.placeholders.multiple') }}" id="{{ $fieldUniqIdentifier }}">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>

@if ($quickCreator)
    <x-slot name="action">
        <a class="quick-creator-subform text-xs cursor-pointer" data-url="{{ route('entity-creator.form', [$campaign, 'entity_type' => config('entities.ids.location'), 'origin' => 'entity-form', 'target' => $fieldUniqIdentifier, 'multi' => true]) }}" aria-label="Create a new location" tabindex="0">
            <x-icon class="plus" />
            {{ __('crud.actions.new') }}
        </a>
    </x-slot>
@endif
</x-forms.field>
