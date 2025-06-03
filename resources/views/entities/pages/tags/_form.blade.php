<?php /** @var \App\Models\Entity $entity */?>
<x-helper>
    <p>{{ __('entities/tags.create.helper', ['name' => $entity->name]) }}</p>
</x-helper>
<x-grid type="1/1">
    @include('cruds.fields.tags', ['model' => $entity, 'enableNew' => true])
</x-grid>


