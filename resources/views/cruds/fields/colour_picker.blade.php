<x-forms.field
    field="colour"
    :label="__('crud.fields.colour')">
    <span>
        <input type="text" name="colour" value="{{ old('colour', $model->colour ?? $default ?? null) }}"
           maxlength="7" class="spectrum" @if (isset($dropdownParent)) data-append-to="{{ $dropdownParent }}" @endif />
    </span>
</x-forms.field>
