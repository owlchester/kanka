@include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])

<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.quest', ['isParent' => true])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.character')
    </div>
</div>
