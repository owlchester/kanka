<?php
/**
 * @var \App\Models\Entity $entity
 */
$child = $entity;
?>

@if (empty($entity->type) && $entity->locations->isEmpty())
    @php return @endphp
@endif


<x-sidebar.profile>
    @include('entities.components.profile._type')
    @include('entities.components.profile._locations')
</x-sidebar.profile>
