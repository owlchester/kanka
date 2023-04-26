
@include('cruds.fields.type', ['base' => \App\Models\Timeline::class, 'trans' => 'families'])
<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.family', ['isParent' => true])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.location')
    </div>
</div>
