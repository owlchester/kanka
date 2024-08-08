<?php /**
 * @var \App\Models\MiscModel $model
 */
if (!$campaign->enabled('locations') || !$model->parent || !$model->parent->entity) {
    return;
}
?>
<div class="entity-header-sub-element">
    <x-icon :class="\App\Facades\Module::duoIcon('location')" :title="__('crud.fields.parent')" />
    @if ($model->parent->parent && $model->parent->parent->entity)
        {!! __('crud.fields.locations', [
            'first' => \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($model->parent->entity, $campaign)
                ),
            'second' => \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($model->parent->parent->entity, $campaign)
                ),
        ]) !!}
    @else
        <x-entity-link
            :entity="$model->parent->entity"
            :campaign="$campaign" />
    @endif
</div>
