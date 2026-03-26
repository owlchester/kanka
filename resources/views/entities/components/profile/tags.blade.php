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
    @includeWhen($entity->aliases->isNotEmpty(), 'entities.components.profile._aliases')
    @if ($child->hasColour())
        <div class="element profile-colour">
            <div class="title text-uppercase text-xs">{{ __('crud.fields.colour') }}</div>
            <div class="flex items-center gap-2">
                <span class="inline-block rounded-full w-4 h-4" style="{{ $child->colourStyle() }}"></span>
                {{ $child->colour }}
            </div>
        </div>
    @endif
    @if ($child->hasIcon())
        <div class="element profile-icon">
            <div class="title text-uppercase text-xs">{{ __('tags.fields.icon') }}</div>
            <i class="{{ $child->icon }}" aria-hidden="true"></i> {{ $child->icon }}
        </div>
    @endif

    @include('entities.components.profile._type')
</x-sidebar.profile>
