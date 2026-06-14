<?php /** @var \App\Models\Timeline $model */ ?>
<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Timeline::class, 'trans' => 'timelines'])

    @include('cruds.fields.parent')

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
</x-grid>
