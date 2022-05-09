<?php /** @var \App\Models\Character $model */?>
@if ($model instanceof \App\Models\Character)
    @if ($model->is_private)
        <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
    @endif
    {!! $model->tooltipedLink() !!}
    @if ($model->is_dead)
        <i class="fa-solid fa-skull" title="{{ __('characters.fields.is_dead') }}"></i>
    @endif
    <br />
    <i>{{ $model->title }}</i>
    <?php return ?>
@endif

@if ($model->character->is_private)
    <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
@endif
{!! $model->character->tooltipedLink() !!}
@if ($model->character->is_dead)
    <i class="fa-solid fa-skull" title="{{ __('characters.fields.is_dead') }}"></i>
@endif
<br />
<i>{{ $model->character->title }}</i>
