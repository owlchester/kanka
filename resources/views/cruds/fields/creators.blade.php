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

@if (isset($bulk) && $bulk)
    <div class="grid gap-2 md:gap-4 grid-cols-2">
@endif

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

@if (isset($bulk) && $bulk)
    <x-forms.field field="bulk-creators" :label="__('items.bulk.creators.action')">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="bulk-creators" value="remove" />
            {{ __('items.bulk.creators.remove') }}
        </label>
    </x-forms.field>
    </div>
@else
    <input type="hidden" name="save_creators" value="1">
@endif
