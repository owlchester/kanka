<?php /**
 * @var \App\Models\Ability $model
 */
?>
@if ($model->ability)
    <div class="entity-header-sub pull-left">
        @if($model->ability)
        <span data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
            <x-icon :class="\App\Facades\Module::duoIcon('ability')" :title="__('crud.fields.parent')" />
            {!! $model->ability->tooltipedLink() !!}
        </span>
        @endif
    </div>
@endif
