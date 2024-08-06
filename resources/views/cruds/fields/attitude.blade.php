<x-forms.field
    field="attitude"
    :label="__('entities/relations.fields.attitude')"
    :helper="__('entities/relations.hints.attitude')"
    tooltip>

    <input type="number" name="attitude" class="w-full" value="{{ old('attitude', $model->attitude ?? null) }}" min="-100" max="100" placeholder="{{ __('entities/relations.placeholders.attitude') }}" />
</x-forms.field>
