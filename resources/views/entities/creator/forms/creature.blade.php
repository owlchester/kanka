<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.type', ['base' => \App\Models\Creature::class, 'trans' => 'creatures'])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.creature', ['parent' => true])
    </div>
</div>
