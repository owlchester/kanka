
@include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])

<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.organisation', ['isParent' => true])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.location')
    </div>
</div>
