<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'locations'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.location', ['isParent' => true])
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
