<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'races'])
        @include('cruds.fields.type', ['base' => \App\Models\Race::class, 'trans' => 'races'])
        @include('cruds.fields.race', ['parent' => true])

        @include('cruds.fields.tags')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>