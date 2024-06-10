<x-forms.field field="date" :label="__('quests.fields.date')">
    <input type="date" name="date" value="{{ old('date', $source->date ?? $model->date ?? null) }}" class="w-full date-picker" />
</x-forms.field>
