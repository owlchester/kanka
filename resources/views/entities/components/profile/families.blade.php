<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Family $model
 */
$child = $entity->child;
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @includeWhen($entity->aliases->isNotEmpty(), 'entities.components.profile._aliases')
    @if (!empty($child->parent))
        <div class="element profile-family">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::singular(config('entities.ids.family'), __('entities.family')) !!}
            </div>
            <x-entity-link
                :entity="$child->parent->entity"
                :campaign="$campaign" />
        </div>
    @endif

    @include('entities.components.profile._type')
    @include('entities.components.profile._events')
</x-sidebar.profile>
