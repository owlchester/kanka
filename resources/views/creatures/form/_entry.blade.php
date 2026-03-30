<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Creature::class, 'trans' => 'creatures'])

    @include('cruds.fields.parent')
    @include('cruds.fields.locations', ['from' => $model ?? null, 'quickCreator' => true])

    @include('cruds.fields.entry2')

    @include('cruds.fields.status')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')

</x-grid>
