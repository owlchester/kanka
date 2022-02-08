
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'maps'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Map::class, 'trans' => 'maps'])
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.map', ['parent' => true, 'from' => (isset($model) ? $model : null)])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.location', ['quickCreator' => true])
    </div>
</div>

@include('cruds.fields.entry2')

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image', ['size' => 'map'])
    </div>
</div>

@include('cruds.fields.private2')
