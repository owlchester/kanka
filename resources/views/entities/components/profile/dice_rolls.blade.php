<?php /** @var \App\Models\DiceRoll $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
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
            <x-entity-link
                :entity="$model->character->entity"
                :campaign="$campaign" />
        </div>
    @endif
</x-sidebar.profile>
