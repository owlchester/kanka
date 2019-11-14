<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model', null);
$enableNew = Arr::get($options, 'enableNew', true);

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old($fieldId);
if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model) && !empty($model->entity)) {
    foreach ($model->entity->tags as $tag) {
        if (\App\Facades\EntityPermission::canView($tag->entity)) {
            $selectedOption[$tag->id] = $tag->name;
        }
    }
}
?>
<label>{{ trans('crud.fields.tags') }}</label>

<select multiple="multiple" name="tags[]" id="tags" class="form-control form-tags" style="width: 100%" data-url="{{ route('tags.find') }}" data-allow-new="{{ $enableNew ? 'true' : 'false' }}" data-new-tag="{{ trans('tags.new_tag') }}">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>
