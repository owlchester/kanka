<?php
/**
 * @var \App\Models\Entity $entity
 */
$child = $entity;
?>

@if (empty($entity->type))
    @php return @endphp
@endif


<x-sidebar.profile>
    @include('entities.components.profile._type')
</x-sidebar.profile>
