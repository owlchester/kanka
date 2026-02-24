<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['trans' => 'crud'])
    @include('cruds.fields.parent', ['trans' => 'crud', 'is_parent' => true])
    @include('cruds.fields.locations', ['from' => $entity ?? null, 'quickCreator' => true, 'model' => $entity ?? $source ?? null])
    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
