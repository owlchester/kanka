<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'races'])
        @include('cruds.fields.type', ['base' => \App\Models\Race::class, 'trans' => 'races'])
        @include('cruds.fields.race', ['parent' => true, 'from' => isset($model) ? $model : null])

        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>

@include('cruds.fields.private2')
