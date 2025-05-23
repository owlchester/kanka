<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model');
$quickCreator = Arr::get($options, 'quickCreator', false);
$dynamicNew = Arr::get($options, 'dynamicNew', false);

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('races[]');
$fieldUniqIdentifier = 'races_' . uniqid();

if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model)) {
    /** @var \App\Models\Race $race */
    foreach ($model->characterRaces as $race) {
        $selectedOption[$race->race->id] = strip_tags($race->race->name);
    }
}

if ($quickCreator) {
    $quickCreator = auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.race'))->first(), $campaign]);
}
?>
<x-forms.field
    field="races"
    :label="\App\Facades\Module::plural(config('entities.ids.race'), __('entities.races'))">

    <select
        id="{{ $fieldUniqIdentifier }}"
        multiple="multiple"
        name="races[]"
        class=" select2 join-item"
        data-tags="true"
        style="width: 100%"
        data-url="{{ route('search-list', [$campaign, config('entities.ids.race')]) }}"
        data-allow-clear="true"
        data-allow-new="{{ $dynamicNew ? 'true' : false}}"
        data-new-tag="{{ __('crud.actions.new') }}"
        data-placeholder="">
        @foreach ($selectedOption as $key => $val)
            <option value="{{ $key }}" selected="selected">{{ $val }}</option>
        @endforeach
    </select>

    @if ($quickCreator)
        <x-slot name="action">
            <a class="quick-creator-subform text-xs cursor-pointer" data-url="{{ route('entity-creator.form', [$campaign, 'entity_type' => config('entities.ids.race'), 'origin' => 'entity-form', 'target' => $fieldUniqIdentifier, 'multi' => true]) }}" aria-label="Create a new race" tabindex="0">
                <x-icon class="plus" />
                {{ __('crud.actions.new') }}
            </a>
        </x-slot>
    @endif
</x-forms.field>
