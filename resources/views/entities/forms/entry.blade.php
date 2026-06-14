<x-grid>
    <div class="flex gap-2 items-end">
        <div>
            @include('cruds.fields.image-gallery', ['new' => true])
        </div>
        <div class="grow">
            @include('cruds.fields.entity-name')
        </div>
    </div>
    
    @include('cruds.fields.type', ['trans' => 'crud'])
    @include('cruds.fields.parent', ['trans' => 'crud', 'is_parent' => true])
    @include('cruds.fields.locations', ['from' => $entity ?? null, 'quickCreator' => true, 'model' => $entity ?? $source ?? null])
    @include('cruds.fields.entry2')

    @include('cruds.fields.status')

    @include('cruds.fields.tags')
</x-grid>
