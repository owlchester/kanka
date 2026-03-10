<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Event $model
 */
$child = $entity->child;
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @includeWhen($entity->aliases->isNotEmpty(), 'entities.components.profile._aliases')
    @include('entities.components.profile._location')
    @include('entities.components.profile._type')
    @include('entities.components.profile._reminder')
</x-sidebar.profile>
