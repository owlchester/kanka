@if (!$campaign->enabled('locations'))
    <?php return ?>
@endif
@if (isset($bulk) && $bulk)
    <div class="grid gap-2 md:gap-4 grid-cols-2">
@endif
<input type="hidden" name="save_locations" value="1">
<x-forms.field field="locations">
    @include('components.form.locations', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'source' => $source ?? null,
        'quickCreator' => $quickCreator ?? false,
        'dynamicNew' => $dynamicNew ?? false
    ]])
</x-forms.field>

@if (isset($bulk) && $bulk)
    <x-forms.field field="bulk-locations" :label="__('crud.bulk.edit.locations')">
        <select name="bulk-locations" class="w-full">
            <option value="add">{{ __('crud.bulk.edit.tags.add') }}</option>
            <option value="remove">{{ __('crud.bulk.edit.tags.remove') }}</option>
        </select>
    </x-forms.field>
    </div>
@endif
