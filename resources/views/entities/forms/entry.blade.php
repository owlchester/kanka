<x-grid>
    @include('cruds.fields.name', ['trans' => $entityType->pluralCode()])
    @include('cruds.fields.type', ['trans' => 'cruds'])
    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
