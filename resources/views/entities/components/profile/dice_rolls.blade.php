<?php /** @var \App\Models\DiceRoll $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if ($entity->child->parameters)
        <div class="element profile-parameters">
            <div class="title text-uppercase text-xs">{{ __('dice_rolls.fields.parameters') }}</div>
            {{ $entity->child->parameters }}
        </div>
    @endif
    @if ($entity->child->character)
        <div class="element profile-parameters">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::singular(config('entities.ids.character'), __('entities.character')) !!}
            </div>
            <x-entity-link
                :entity="$entity->child->character->entity"
                :campaign="$campaign" />
        </div>
    @endif
</x-sidebar.profile>
