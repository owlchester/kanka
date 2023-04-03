<?php /** @var \App\Models\Quest $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<div class="sidebar-section-box sidebar-section-profile">
    <div class="sidebar-section-title cursor-pointer text-lg user-select" data-toggle="collapse" data-target="#sidebar-profile-elements">
        <i class="fa-solid fa-chevron-right" style="display: none"></i>
        <i class="fa-solid fa-chevron-down"></i>
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements grid my-1 collapse !visible in" id="sidebar-profile-elements">
        @if (!empty($model->character))
            <div class="element profile-instigator">
                <div class="title text-uppercase text-xs">{{ __('quests.fields.character') }}</div>
                {!! $model->character->tooltipedLink() !!}
            </div>
        @endif

        @if ($model->date)
            <div class="element profile-date">
                <div class="title text-uppercase text-xs">{{ __('journals.fields.date') }}</div>
                {{ \App\Facades\UserDate::format($model->date) }}
            </div>
        @endif
        @include('entities.components.profile._reminder')

        @include('entities.components.profile._type')
    </div>
</div>
