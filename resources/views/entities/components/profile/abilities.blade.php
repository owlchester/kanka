<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Ability $model
 */
$child = $entity->child;
?>
@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($child->charges))
        <div class="element profile-charges">
            <div class="title text-uppercase text-xs">{{ __('abilities.fields.charges') }}</div>
            {{ $child->charges }}
        </div>
    @endif
    @include('entities.components.profile._type')
</x-sidebar.profile>
