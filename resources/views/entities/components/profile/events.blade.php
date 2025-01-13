<?php /** @var \App\Models\Event $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._location')
    @include('entities.components.profile._type')
    @include('entities.components.profile._reminder')
</x-sidebar.profile>
