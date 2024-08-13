<x-grid>
    @include('cruds.fields.name', ['trans' => 'creatures'])
    @include('cruds.fields.type', ['base' => \App\Models\Creature::class, 'trans' => 'creatures'])

    @include('cruds.fields.creature', ['isParent' => true])
    @include('cruds.fields.locations', ['from' => $model ?? null, 'quickCreator' => true])

    @include('cruds.fields.entry2')

    <x-forms.field field="extinct" :label="__('creatures.fields.is_extinct')">
        <input type="hidden" name="is_extinct" value="0" />
        <x-checkbox :text="__('creatures.hints.is_extinct')">
            <input type="checkbox" name="is_extinct" value="1" @if (old('is_extinct', $source->is_extinct ?? $model->is_extinct ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    <x-forms.field
        field="dead"
        :label="__('characters.fields.is_dead')">
        <input type="hidden" name="is_dead" value="0" />
        <x-checkbox :text="__('creatures.hints.is_dead')">
            <input type="checkbox" name="is_dead" value="1" @if (old('is_dead', $source->is_dead ?? $model->is_dead ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.tags')
    @include('cruds.fields.image')

</x-grid>
