<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Conversation $model
 */
$child = $entity->child;
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    <div class="element profile-target">
        <div class="title text-uppercase text-xs">{{ __('conversations.fields.participants') }}</div>
        {{ $child->forEntities() ? __('entities.entries') : __('conversations.targets.members') }}
    </div>

    @include('entities.components.profile._type')
</x-sidebar.profile>
