@if ($campaignService->enabled('tags'))
    @if (isset($bulk) && $bulk)
        <div class="grid gap-2 md:gap-4 grid-cols-2">
    @endif
    <div class="tags form-group">
        <input type="hidden" name="save-tags" value="1" />

        <x-forms.tags
            :model="isset($model) ? $model : FormCopy::model()"
            :enableNew="isset($enableNew) ? $enableNew : auth()->user()->can('create', \App\Models\Tag::class)"
            :dropdownParent="$dropdownParent ?? null"
            allowNew="true"
            allowClear="false"
            enableAuto="true"
        ></x-forms.tags>
    </div>

    @if (isset($bulk) && $bulk)
        <div class="form-group">
            <label for="bulk-tagging">{{ __('crud.bulk.edit.tagging') }}</label>
            <select name="bulk-tagging" class="form-control">
                <option value="add">{{ __('crud.bulk.edit.tags.add') }}</option>
                <option value="remove">{{ __('crud.bulk.edit.tags.remove') }}</option>
            </select>
        </div>
        </div>
    @endif
@endif
