

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'notes'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.note', ['isParent' => true])
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
