<?php /** @var \App\Models\Character $model */?>
@if ($model instanceof \App\Models\Character)
    @if ($model->entity->is_private)
        <x-icon class="lock" title="{{ __('crud.is_private') }}" tooltip></x-icon>
    @endif
    <x-entity-link
        :entity="$model->entity"
        :campaign="$campaign" />
    @if ($model->entity->status)
        <x-icon class="fa-regular {{ $model->entity->status->icon }}" title="{{ $model->entity->status->setRelation('entityType', $model->entity->entityType)->name() }}"></x-icon>
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
@if ($model->status)
    <x-icon class="fa-regular {{ $model->status->icon }}" title="{{ $model->status->setRelation('entityType', $model->entityType)->name() }}" tooltip></x-icon>
@endif
<br />
<span class="italic character-title text-xs">{!! $model->character->title !!}</span>
