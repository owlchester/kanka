<x-forms.field
    field="attitude"
    :label="__('entities/relations.fields.attitude')"
    :helper="__('entities/relations.hints.attitude')"
    tooltip>

    <div x-data="{ value: {{ (int) old('attitude', $model->attitude ?? 0) }} }" class="flex items-center gap-3">
        <input type="range" name="attitude" x-model="value" min="-100" max="100" step="1" class="w-full"/>
        <span x-text="value" class="text-sm tabular-nums w-10 text-right shrink-0"></span>
    </div>
</x-forms.field>
