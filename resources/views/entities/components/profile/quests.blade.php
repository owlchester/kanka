<?php /** @var \App\Models\Quest $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($entity->child->instigator))
        <div class="element profile-instigator">
            <div class="title text-uppercase text-xs">{{ __('quests.fields.instigator') }}</div>
            <x-entity-link
                :entity="$model->instigator"
                :campaign="$campaign" />
        </div>
    @endif

    @if ($entity->child->date)
        <div class="element profile-date">
            <div class="title text-uppercase text-xs">{{ __('journals.fields.date') }}</div>
            {{ \App\Facades\UserDate::format($entity->child->date) }}
        </div>
    @endif
    @include('entities.components.profile._reminder')

    @include('entities.components.profile._type')
</x-sidebar.profile>
