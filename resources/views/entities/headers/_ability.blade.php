<?php /**
 * @var \App\Models\Ability $model
 */
?>
@if ($model->ability)
    <div class="entity-header-sub pull-left">
        @if($model->ability)
        <span class="mr-2">
        <i class="ra ra-fire-symbol" title="{{ __('abilities.fields.ability') }}" data-toggle="tooltip" ></i>
        {!! $model->ability->tooltipedLink() !!}
        </span>
        @endif
    </div>
@endif
