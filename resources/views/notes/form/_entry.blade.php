

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'notes'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
    </div>
</div>



@include('cruds.fields.entry2')


<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>
