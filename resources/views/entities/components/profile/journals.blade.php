<?php /** @var \App\Models\Journal $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._location')
    @if ($entity->child->date)
        <div class="element profile-date">
            <div class="title text-uppercase text-xs">{{ __('journals.fields.date') }}</div>
            {{ \App\Facades\UserDate::format($entity->child->date) }}
        </div>
    @endif

    @if ($entity->child->author)
        <div class="element profile-character">
            <div class="title text-uppercase text-xs">{{ __('journals.fields.author') }}</div>
            <x-entity-link
                :entity="$entity->child->author"
                :campaign="$campaign" />
        </div>
    @endif
    @include('entities.components.profile._reminder')

    @include('entities.components.profile._type')
</x-sidebar.profile>
