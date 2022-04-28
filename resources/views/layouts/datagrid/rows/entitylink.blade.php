@if ($model->is_private)
    <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
@endif
{!! $model->tooltipedLink() !!}
