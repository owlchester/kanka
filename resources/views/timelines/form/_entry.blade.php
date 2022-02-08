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
        @include('cruds.fields.timeline', ['parent' => true, 'from' => isset($model) ? $model : null])
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

@include('cruds.fields.private2')
