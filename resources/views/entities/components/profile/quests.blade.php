<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Quest $model
 */
$child = $entity->child;
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($child->instigator))
        <div class="element profile-instigator">
            <div class="title text-uppercase text-xs">{{ __('quests.fields.instigator') }}</div>
            <x-entity-link
                :entity="$child->instigator"
                :campaign="$campaign" />
        </div>
    @endif

    @if ($child->date)
        <div class="element profile-date">
            <div class="title text-uppercase text-xs">{{ __('journals.fields.date') }}</div>
            {{ \App\Facades\UserDate::format($child->date) }}
        </div>
    @endif
    @include('entities.components.profile._reminder')
    @include('entities.components.profile._location')

    @include('entities.components.profile._type')
</x-sidebar.profile>
