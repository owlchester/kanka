<?php
$selectedOption = [];
$model = $model ?? FormCopy::model();
$fieldUniqIdentifier = 'creators_' . uniqid();

$previous = old('creators[]');

if (!empty($previous)) {
    // Form validation error, reload previous
} elseif (!empty($model)) {
    foreach ($model->itemCreators as $itemCreator) {
        $selectedOption[$itemCreator->creator->id] = strip_tags($itemCreator->creator->name);
    }
}
?>

<input type="hidden" name="save_creators" value="1">
<x-forms.field
    field="creators"
    :label="__('items.fields.creators')">

<select
    multiple="multiple"
    name="creators[]"
    class="w-full select2 join-item"
    data-tags="true"
    style="width: 100%"
    data-url="{{ route('search.entities-with-relations', [$campaign]) }}"
    data-allow-clear="true"
    data-placeholder="{{ __('crud.placeholders.search') }}"
    data-allow-new="false"
    id="{{ $fieldUniqIdentifier }}">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>

</x-forms.field>
