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
    @includeWhen($entity->aliases->isNotEmpty(), 'entities.components.profile._aliases')
    @include('entities.components.profile._locations')
    @include('entities.components.profile._type')
</x-sidebar.profile>
