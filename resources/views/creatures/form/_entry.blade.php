<x-grid>
    @include('cruds.fields.name', ['trans' => 'creatures'])
    @include('cruds.fields.type', ['base' => \App\Models\Creature::class, 'trans' => 'creatures'])

    @include('cruds.fields.creature', ['isParent' => true])
    @include('cruds.fields.locations', ['from' => $model ?? null, 'quickCreator' => true])

    @include('cruds.fields.entry2')

    <x-forms.field field="extinct" :label="__('creatures.fields.is_extinct')">
        <input type="hidden" name="is_extinct" value="0" />
        <x-checkbox :text="__('creatures.hints.is_extinct')">
            {!! Form::checkbox('is_extinct', 1, $model->is_extinct ?? '' )!!}
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.tags')
    @include('cruds.fields.image')

</x-grid>
