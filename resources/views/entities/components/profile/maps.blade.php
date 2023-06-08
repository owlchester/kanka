<?php /** @var \App\Models\Map $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._type')
</x-sidebar.profile>
