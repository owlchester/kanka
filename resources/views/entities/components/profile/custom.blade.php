<?php
/**
 * @var \App\Models\Entity $entity
 */
$child = $entity;
?>

@if (empty($entity->type) && $entity->locations->isEmpty() && $entity->aliases->isEmpty())
    @php return @endphp
@endif


<x-sidebar.profile>
    @include('entities.components.profile._type')
    @include('entities.components.profile._locations')
    @includeWhen($entity->aliases->isNotEmpty(), 'entities.components.profile._aliases')
</x-sidebar.profile>
