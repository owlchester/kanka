<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])

    @include('cruds.fields.ability', ['isParent' => true])
    @include('cruds.fields.charges')

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
