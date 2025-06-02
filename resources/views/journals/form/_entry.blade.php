<x-grid>
    @include('cruds.fields.name', ['trans' => 'journals'])
    @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])

    @include('cruds.fields.journal', ['isParent' => true])

    @include('cruds.fields.author')
    @include('cruds.fields.location')

    @include('cruds.fields.date')

    <div class="col-span-2">
        @include('cruds.forms._calendar', ['source' => $source])
    </div>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
