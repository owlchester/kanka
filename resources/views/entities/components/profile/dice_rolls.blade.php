<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\DiceRoll $model
 */
$child = $entity->child;
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if ($child->parameters)
        <div class="element profile-parameters">
            <div class="title text-uppercase text-xs">{{ __('dice_rolls.fields.parameters') }}</div>
            {{ $child->parameters }}
        </div>
    @endif
    @if ($child->character)
        <div class="element profile-parameters">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::singular(config('entities.ids.character'), __('entities.character')) !!}
            </div>
            <x-entity-link
                :entity="$child->character->entity"
                :campaign="$campaign" />
        </div>
    @endif
</x-sidebar.profile>
