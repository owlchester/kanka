<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Tag $model
 */
$child = $entity->child;
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($child->colour))
        <div class="element profile-colour">
            <div class="title text-uppercase text-xs">{{ __('crud.fields.colour') }}</div>
            {{ $child->colour }}
        </div>
    @endif

    @include('entities.components.profile._type')
</x-sidebar.profile>
