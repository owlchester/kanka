<?php /** @var \App\Models\Tag $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($model->colour))
        <div class="element profile-colour">
            <div class="title text-uppercase text-xs">{{ __('crud.fields.colour') }}</div>
            {{ $model->colour }}
        </div>
    @endif

    @include('entities.components.profile._type')
</x-sidebar.profile>
