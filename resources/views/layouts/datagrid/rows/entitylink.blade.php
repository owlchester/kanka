@if ($model instanceof \App\Models\Entity)
    @if ($model->is_private)
        <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
    @endif
    {!! $model->tooltipedLink() !!}
    <?php return ?>
@endif

@if ($model->entity->is_private)
    <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
@endif
{!! $model->entity->tooltipedLink() !!}
