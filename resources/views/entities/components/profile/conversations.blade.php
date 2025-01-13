<?php /** @var \App\Models\Conversation $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    <div class="element profile-target">
        <div class="title text-uppercase text-xs">{{ __('conversations.fields.participants') }}</div>
        {{ __('conversations.targets.' . ($entity->child->forCharacters() ? 'characters' : 'members')) }}
    </div>

    @include('entities.components.profile._type')
</x-sidebar.profile>
