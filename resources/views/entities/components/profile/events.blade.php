<?php /** @var \App\Models\Event $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._location')
    @include('entities.components.profile._type')
</x-sidebar.profile>
