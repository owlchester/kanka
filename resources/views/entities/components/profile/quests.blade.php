<?php /** @var \App\Models\Quest $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<div class="sidebar-section-box sidebar-section-profile">
    <div class="sidebar-section-title cursor" data-toggle="collapse" data-target="#sidebar-profile-elements">
        <i class="fa fa-chevron-right" style="display: none"></i>
        <i class="fa fa-chevron-down"></i>
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements collapse in" id="sidebar-profile-elements">
        @if (!empty($model->character))
            <div class="element profile-instigator">
                <div class="title">{{ __('quests.fields.character') }}</div>
                {!! $model->character->tooltipedLink() !!}
            </div>
        @endif

        @if ($model->date)
            <div class="element profile-date">
                <div class="title">{{ __('journals.fields.date') }}</div>
                {{ $model->date }}
            </div>
        @endif

        @include('entities.components.profile._type')
    </div>
</div>
