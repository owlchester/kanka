<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOptions = [];

$model = Arr::get($options, 'model', null);
$options = \App\Models\RpgSystem::ordered()->get();

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old($fieldId);
if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model)) {
    foreach ($model->rpgSystems as $system) {
        $selectedOptions[] = $system->id;
    }
}
?>
<label>{{ trans('campaigns.fields.rpg_system') }}</label>

<select multiple="multiple" name="rpg_systems[]" id="rpg_systems" class="form-control form-rpg-systems" style="width: 100%">
    @foreach ($options as $rpgSystem)
        <option value="{{ $rpgSystem->id }}" @if (in_array($rpgSystem->id, $selectedOptions)) selected="selected" @endif >
            {{ $rpgSystem->name() }}
        </option>
    @endforeach
</select>
