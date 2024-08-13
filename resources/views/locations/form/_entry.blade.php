<x-grid>
    @include('cruds.fields.name', ['trans' => 'locations'])

    @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])

    @include('cruds.fields.location', ['isParent' => true])

    @include('cruds.fields.entry2')
    
    @include('cruds.fields.destroyed')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
