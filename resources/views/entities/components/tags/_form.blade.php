<?php /** @var \App\Models\Entity $entity */?>
{{ csrf_field() }}
<x-grid type="1/1">
    @include('cruds.fields.tags', ['model' => $entity])
</x-grid>


