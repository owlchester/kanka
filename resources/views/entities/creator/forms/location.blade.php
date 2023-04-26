<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.location', ['isParent' => true])
    </div>
</div>

