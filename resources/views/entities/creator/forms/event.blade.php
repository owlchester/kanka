<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Event::class, 'trans' => 'events'])

    <x-forms.field
        field="date"
        :label="__('events.fields.date')">
        <input type="text" name="date" value="{!! htmlspecialchars(old('date', $source->date ?? $model->date ?? null)) !!}" maxlength="191" class="w-full" placeholder="{{ __('events.placeholders.date') }}" />
    </x-forms.field>

    @include('cruds.fields.location')
</x-grid>
