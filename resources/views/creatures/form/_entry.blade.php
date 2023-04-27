<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'creatures'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Creature::class, 'trans' => 'creatures'])
    </div>
</div>
<div class="row">

    <div class="col-md-6">
        @include('cruds.fields.creature', ['isParent' => true])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.locations', ['from' => isset($model) ? $model : null, 'quickCreator' => true])
    </div>
</div>

@include('cruds.fields.entry2')

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>
