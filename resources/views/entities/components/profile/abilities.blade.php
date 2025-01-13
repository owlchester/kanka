<?php /** @var \App\Models\Ability $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($entity->child->charges))
        <div class="element profile-charges">
            <div class="title text-uppercase text-xs">{{ __('abilities.fields.charges') }}</div>
            {{ $entity->child->charges }}
        </div>
    @endif
    @include('entities.components.profile._type')
</x-sidebar.profile>
