
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'maps'])
        @include('cruds.fields.type', ['base' => \App\Models\Map::class, 'trans' => 'maps'])
        @include('cruds.fields.map', ['parent' => true])
        @include('cruds.fields.location')

        @include('cruds.fields.tags')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image', ['size' => 'map'])
    </div>
</div>
