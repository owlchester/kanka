<?php /** @var \App\Models\Character $model */?>
@if ($model instanceof \App\Models\Character)
    @if ($model->entity->is_private)
        <x-icon class="lock" title="{{ __('crud.is_private') }}" tooltip></x-icon>
    @endif
    <x-entity-link
        :entity="$model->entity"
        :campaign="$campaign" />
    @if ($model->isDead())
        <x-icon class="fa-regular fa-skull" title="{{ __('characters.hints.is_dead') }}" tooltip></x-icon>
    @elseif ($model->isMissing())
        <x-icon class="fa-regular fa-question" title="{{ __('characters.hints.is_missing') }}" tooltip></x-icon>
    @endif
    <br />
    <span class="italic character-title text-xs">{!! $model->title !!}</span>
    <?php return ?>
@endif

@if ($model->character->entity->is_private)
    <x-icon class="lock" title="{{ __('crud.is_private') }}" tooltip></x-icon>
@endif
<x-entity-link
    :entity="$model->character->entity"
    :campaign="$campaign" />
@if ($model->character->isDead())
    <i class="fa-solid fa-skull" aria-hidden="true" data-title="{{ __('characters.hints.is_dead') }}"></i>
@elseif ($model->character->isMissing())
    <i class="fa-regular fa-question" aria-hidden="true" data-title="{{ __('characters.hints.is_missing') }}"></i>
@endif
<br />
<span class="italic character-title text-xs">{!! $model->character->title !!}</span>
