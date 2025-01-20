<x-grid>
    @include('cruds.fields.name', ['trans' => $entityType->pluralCode()])
    @include('cruds.fields.type', ['trans' => 'crud'])
    @include('cruds.fields.parent', ['trans' => 'crud', 'is_parent' => true])
    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
