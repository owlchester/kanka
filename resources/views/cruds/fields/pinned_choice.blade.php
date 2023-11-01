<x-forms.field
    field="pinned"
    :label="__('crud.fields.is_star')">
    <select name="is_pinned" class="w-full">
        <option value=""></option>
        <option value="0">{{ trans('general.no') }}</option>
        <option value="1">{{ trans('general.yes') }}</option>
    </select>
</x-forms.field>
