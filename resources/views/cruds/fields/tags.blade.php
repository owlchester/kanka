@if ($campaign->enabled('tags'))
    @if (isset($bulk) && $bulk)
        <div class="grid gap-2 md:gap-4 grid-cols-2">
    @endif
    <x-forms.field field="tags">
        <input type="hidden" name="save-tags" value="1" />

        <x-forms.tags
            :campaign="$campaign"
            :model="$model ?? $source ?? null"
            :dropdownParent="$dropdownParent ?? null"
            :allowNew="isset($bulk) ? false : $enableNew  ?? false"
            allowClear="false"
            enableAuto="true"
            :entityTypeID="config('entities.ids.tag')"
        ></x-forms.tags>
    </x-forms.field>

    @if (isset($bulk) && $bulk)
        <x-forms.field field="tagging" :label="__('crud.bulk.edit.tagging')">
            <select name="bulk-tagging" class="w-full">
                <option value="add">{{ __('crud.bulk.edit.tags.add') }}</option>
                <option value="remove">{{ __('crud.bulk.edit.tags.remove') }}</option>
            </select>
        </x-forms.field>
        </div>
    @endif
@endif
