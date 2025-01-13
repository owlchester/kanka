<?php /** @var \App\Models\Map $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._type')
</x-sidebar.profile>
