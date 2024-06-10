<x-forms.field
    field="colour"
    :required="$required ?? false"
    :label="__('crud.fields.colour')"
>
    <x-forms.select name="colour" :options="FormCopy::colours()" :selected="$source->colour ?? $model->colour ?? $default ?? null" class="w-full select2-colour" />
</x-forms.field>
