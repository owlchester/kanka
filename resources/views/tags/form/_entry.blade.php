<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'tags'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tag', ['parent' => true, 'from' => isset($model) ? $model : null, 'quickCreator' => true])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.colour')
    </div>
</div>

@include('cruds.fields.entry2')

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>

@include('cruds.fields.private2')
