<?php /** @var \App\Models\DiceRoll $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<div class="sidebar-section-box sidebar-section-profile">
    <div class="sidebar-section-title cursor" data-toggle="collapse" data-target="#sidebar-profile-elements">
        <i class="fa-solid fa-chevron-right" style="display: none"></i>
        <i class="fa-solid fa-chevron-down"></i>
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements collapse in" id="sidebar-profile-elements">
        @if ($model->parameters)
            <div class="element profile-parameters">
                <div class="title">{{ __('dice_rolls.fields.parameters') }}</div>
                {{ $model->parameters }}
            </div>
        @endif
        @if ($model->character)
            <div class="element profile-parameters">
                <div class="title">{{ __('crud.fields.character') }}</div>
                {!! $model->character->tooltipedLink() !!}
            </div>
        @endif

    </div>
</div>
