<?php /** @var \App\Models\Timeline $model */ ?>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'timelines'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Timeline::class, 'trans' => 'timelines'])
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.timeline', ['isParent' => true])
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
