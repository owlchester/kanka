<?php /**
 * @var \App\Models\MiscModel $model
 */
if (!$campaign->enabled('locations') || !$model->location || !$model->location->entity) {
    return;
}
?>
<div class="entity-header-sub-element">
    <x-icon :class="\App\Facades\Module::duoIcon('location')" :title="__('crud.fields.parent')" />
    @if ($model->location->location && $model->location->location->entity)
        {!! __('crud.fields.locations', [
            'first' => \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($model->location->entity, $campaign)
                ),
            'second' => \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($model->location->location->entity, $campaign)
                ),
        ]) !!}
    @else
        <x-entity-link
            :entity="$model->location->entity"
            :campaign="$campaign" />
    @endif
</div>
