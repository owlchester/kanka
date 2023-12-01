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

// From source to exclude duplicates
$searchParams = [$campaign];
if (Arr::has($options, 'exclude', false)) {
    $searchParams['exclude'] = Arr::get($options, 'exclude');
} elseif (Arr::has($options, 'exclude-entity', false)) {    
    $searchParams['exclude-entity'] = Arr::get($options, 'exclude-entity');
}

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('entities[]');
if (!empty($previous)) {
    //dd($previous);
}
?>
@if ($label)
<label>
   {{ __('abilities.show.tabs.entities') }}
</label>
@endif

<select
    multiple="multiple"
    name="entities[]"
    id="{{ Arr::get($options, 'id', 'entities[]') }}"
    class="w-full form-tags form-entities"
    style="width: 100%"
    data-url="{{ route('search.ability-entities', $searchParams) }}"
    data-allow-new="{{ $enableNew ? 'true' : 'false' }}"
    data-allow-clear="{{ Arr::get($options, 'allowClear', 'true') }}"
    data-new-tag="{{ __('entities.new_entity') }}"
    data-placeholder="{{ __('entities/relations.placeholders.target') }}"
    :dropdownParent="$dropdownParent ?? (request()->ajax() ? '#primary-dialog' : null)"
>
    @foreach ($selectedOption as $key => $entity)
        <option value="{{ $key }}" class="select2-entity" selected="selected">{{ $entity->name }}</option>
    @endforeach
</select>
