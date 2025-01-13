<?php /** @var \App\Models\Tag $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($entity->child->colour))
        <div class="element profile-colour">
            <div class="title text-uppercase text-xs">{{ __('crud.fields.colour') }}</div>
            {{ $entity->child->colour }}
        </div>
    @endif

    @include('entities.components.profile._type')
</x-sidebar.profile>
