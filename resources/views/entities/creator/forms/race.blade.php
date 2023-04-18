<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.type', ['base' => \App\Models\Race::class, 'trans' => 'races'])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.race', ['parent' => true, 'quickCreator' => true])
    </div>
</div>
