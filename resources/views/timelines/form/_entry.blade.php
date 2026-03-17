<?php /** @var \App\Models\Timeline $model */ ?>
<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Timeline::class, 'trans' => 'timelines'])

    @include('cruds.fields.parent')

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
