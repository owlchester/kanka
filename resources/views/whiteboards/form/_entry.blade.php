<?php /** @var \App\Models\Timeline $model */ ?>
<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Whiteboard::class, 'trans' => 'whiteboards'])

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
