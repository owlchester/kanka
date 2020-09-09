<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model', null);
$enableNew = Arr::get($options, 'enableNew', true);
$label = Arr::get($options, 'label', true);
$filterOptions = Arr::get($options, 'filterOptions', []);
if (!is_array($filterOptions)) {
    $filterOptions = [$filterOptions];
}

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old($fieldId);
if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model) && !empty($model->entity)) {
    foreach ($model->entity->tags()->with('entity')->has('entity')->get() as $tag) {
        if (\App\Facades\EntityPermission::canView($tag->entity)) {
            $selectedOption[$tag->id] = $tag;
        }
    }
} elseif(!empty($model) && $model instanceof \App\Models\CampaignDashboardWidget) {
    foreach ($model->tags()->get() as $tag) {
        $selectedOption[$tag->id] = $tag;
    }
} elseif (!empty($filterOptions)) {
    foreach ($filterOptions as $tagId) {
        if (!empty($tagId)) {
            $tag = \App\Models\Tag::find($tagId);
            if ($tag && \App\Facades\EntityPermission::canView($tag->entity)) {
                $selectedOption[$tag->id] = $tag;
            }
        }
    }
}
?>
@if ($label)
<label>{{ trans('crud.fields.tags') }}</label>
@endif

<select multiple="multiple" name="tags[]" id="{{ Arr::get($options, 'id', 'tags[]') }}" class="form-control form-tags" style="width: 100%" data-url="{{ route('tags.find') }}" data-allow-new="{{ $enableNew ? 'true' : 'false' }}" data-allow-clear="{{ Arr::get($options, 'allowClear', 'true') }}" data-new-tag="{{ trans('tags.new_tag') }}" data-placeholder="">
    @foreach ($selectedOption as $key => $tag)
        <option value="{{ $key }}" data-colour="{{ $tag->colourClass() }}" selected="selected">{{ $tag->name }}</option>
    @endforeach
</select>
