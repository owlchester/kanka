
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'notes'])
        @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
        @include('cruds.fields.tags')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>