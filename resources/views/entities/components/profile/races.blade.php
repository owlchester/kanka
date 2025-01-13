<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Race $model
 */
$child = $entity->child;
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._locations')
    @include('entities.components.profile._type')
</x-sidebar.profile>
