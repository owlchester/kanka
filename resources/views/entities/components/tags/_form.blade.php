<?php /** @var \App\Models\Entity $model */?>
{{ csrf_field() }}
<x-grid type="1/1">
    @include('cruds.fields.tags')
</x-grid>


