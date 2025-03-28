<?php /** @var \App\Models\Entity $entity */?>
<x-helper>
    {{ __('entities/tags.create.helper', ['name' => $entity->name]) }}
</x-helper>
<x-grid type="1/1">
    @include('cruds.fields.tags', ['model' => $entity, 'enableNew' => true])
</x-grid>


