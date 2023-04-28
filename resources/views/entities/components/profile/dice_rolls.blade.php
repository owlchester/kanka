<?php /** @var \App\Models\DiceRoll $model */?>

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
        @if ($model->parameters)
            <div class="element profile-parameters">
                <div class="title text-uppercase text-xs">{{ __('dice_rolls.fields.parameters') }}</div>
                {{ $model->parameters }}
            </div>
        @endif
        @if ($model->character)
            <div class="element profile-parameters">
                <div class="title text-uppercase text-xs">
                    {!! \App\Facades\Module::singular(config('entities.ids.character'), __('entities.character')) !!}
                </div>
                {!! $model->character->tooltipedLink() !!}
            </div>
        @endif

    </div>
</div>
