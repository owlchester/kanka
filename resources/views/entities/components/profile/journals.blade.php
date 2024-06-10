<?php /** @var \App\Models\Journal $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._location')
    @if ($model->date)
        <div class="element profile-date">
            <div class="title text-uppercase text-xs">{{ __('journals.fields.date') }}</div>
            {{ \App\Facades\UserDate::format($model->date) }}
        </div>
    @endif

    @if ($model->author)
        <div class="element profile-character">
            <div class="title text-uppercase text-xs">{{ __('journals.fields.author') }}</div>
            <x-entity-link
                :entity="$model->author"
                :campaign="$campaign" />
        </div>
    @endif
    @include('entities.components.profile._reminder')

    @include('entities.components.profile._type')
</x-sidebar.profile>
