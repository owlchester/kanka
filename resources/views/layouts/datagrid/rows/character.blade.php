<?php /** @var \App\Models\Character $model */?>
@if ($model instanceof \App\Models\Character)
    @if ($model->is_private)
        <i class="fa-solid fa-lock" aria-hidden="true" data-title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
    @endif
    <x-entity-link
        :entity="$model->entity"
        :campaign="$campaign" />
    @if ($model->is_dead)
        <i class="fa-solid fa-skull" aria-hidden="true" data-title="{{ __('characters.fields.is_dead') }}"></i>
    @endif
    <br />
    <span class="italic character-title text-xs">{!! $model->title !!}</span>
    <?php return ?>
@endif

@if ($model->character->is_private)
    <i class="fa-solid fa-lock" aria-hidden="true" data-title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
@endif
<x-entity-link
    :entity="$model->character->entity"
    :campaign="$campaign" />
@if ($model->character->is_dead)
    <i class="fa-solid fa-skull" aria-hidden="true" data-title="{{ __('characters.fields.is_dead') }}"></i>
@endif
<br />
<span class="italic character-title text-xs">{!! $model->character->title !!}</span>
