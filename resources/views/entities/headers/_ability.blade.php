<?php /**
 * @var \App\Models\Ability $model
 */
?>
@if ($model->ability)
    <div class="entity-header-sub pull-left">
        @if($model->ability)
        <span class="mr-2">
        <i class="{{ config('entities.icons.ability') }}" data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip" aria-hidden="true" ></i>
        {!! $model->ability->tooltipedLink() !!}
        </span>
        @endif
    </div>
@endif
