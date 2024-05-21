<?php /** @var \App\Models\Organisation $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._locations')
    @include('entities.components.profile._type')
    @include('entities.components.profile._events')
</x-sidebar.profile>
