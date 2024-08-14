<x-grid>
    @include('cruds.fields.name', ['trans' => 'races'])
    @include('cruds.fields.type', ['base' => \App\Models\Race::class, 'trans' => 'races'])

    @include('cruds.fields.race', ['isParent' => true])
    @include('cruds.fields.locations', ['from' => $model ?? null, 'quickCreator' => true])

    @include('cruds.fields.entry2')

    <x-forms.field field="extinct" :label="__('creatures.fields.is_extinct')">
        <input type="hidden" name="is_extinct" value="0" />
        <x-checkbox :text="__('races.hints.is_extinct')">
            <input type="checkbox" name="is_extinct" value="1" @if (old('is_extinct', $source->is_extinct ?? $model->is_extinct ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
