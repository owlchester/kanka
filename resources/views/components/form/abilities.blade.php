<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 * @var \App\Models\MiscModel $model
 */
$selectedOption = [];

$model = Arr::get($options, 'model', null);
$enableNew = Arr::get($options, 'enableNew', true);
$label = Arr::get($options, 'label', true);
$filterOptions = Arr::get($options, 'filterOptions', []);
if (!is_array($filterOptions)) {
    $filterOptions = [$filterOptions];
}
// From source to exclude duplicates
$searchParams = [$campaign, config('entities.id.ability')];
if (Arr::has($options, 'exclude', false)) {
    $searchParams['exclude'] = Arr::get($options, 'exclude');
} elseif (Arr::has($options, 'exclude-entity', false)) {
    $searchParams['exclude-entity'] = Arr::get($options, 'exclude-entity');
}

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('abilities[]');
if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model) && !empty($model->entity)) {
    foreach ($model->entity->abilities()->with('entity')->has('entity')->get() as $ability) {
        $selectedOption[$ability->id] = $ability;
    }
} elseif (!empty($filterOptions)) {
    foreach ($filterOptions as $abilityId) {
        if (!empty($abilityId)) {
            $ability = \App\Models\Ability::find($abilityId);
            if ($ability) {
                $selectedOption[$ability->id] = $ability;
            }
        }
    }
}
?>
@if ($label)
<label>
    {!! \App\Facades\Module::plural(config('entities.ids.ability'), __('entities.abilities')) !!}
</label>
@endif

<select
    multiple="multiple"
    name="abilities[]"
    id="{{ Arr::get($options, 'id', 'abilities[]') }}"
    class="w-full form-tags form-abilities"
    style="width: 100%"
    data-url="{{ route('search-list', $searchParams) }}"
    data-allow-new="{{ $enableNew ? 'true' : 'false' }}"
    data-allow-clear="{{ Arr::get($options, 'allowClear', 'true') }}"
    data-new-tag="{{ __('abilities.new_ability') }}"
    data-placeholder=""
    @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif
>
    @foreach ($selectedOption as $key => $ability)
        <option value="{{ $key }}" class="select2-ability" selected="selected">{{ $ability->name }}</option>
    @endforeach
</select>
