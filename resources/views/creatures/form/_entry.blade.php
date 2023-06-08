<x-grid>
    @include('cruds.fields.name', ['trans' => 'creatures'])
    @include('cruds.fields.type', ['base' => \App\Models\Creature::class, 'trans' => 'creatures'])

    @include('cruds.fields.creature', ['isParent' => true])
    @include('cruds.fields.locations', ['from' => isset($model) ? $model : null, 'quickCreator' => true])

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')

</x-grid>
