<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Tag $tag
 */
if (!isset($offset)) {
    $offset = 0;
}
$entityType = $widget->conf('entity');
$entity = \App\Models\Entity::
        inTags($widget->tags->pluck('id')->toArray())
        ->whereNotIn('type', ['attribute_template', 'conversation', 'tag'])
        ->type($entityType)
        ->acl()
        ->with(['updater'])
        ->whereNotIn('entities.id', \App\Facades\Dashboard::excluding())
        ->inRandomOrder()
        ->first();

if (empty($entity) || empty($entity->child)) {
    return;
}
\App\Facades\Dashboard::add($entity);
$model = $entity->child;

$specificPreview = 'dashboard.widgets.previews.' . $entity->type;
?>
@if(view()->exists($specificPreview))
    @include($specificPreview, ['entity' => $entity])
@else
<div class="panel panel-default widget-preview" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading @if ($widget->conf('entity-header') && $campaign->boosted() && $entity->header_image) panel-heading-entity" style="background-image: url({{ $entity->getImageUrl(0, 0, 'header_image') }}) @elseif ($model->image) panel-heading-entity" style="background-image: url({{ $model->getImageUrl() }}) @endif">
        <h3 class="panel-title">
            <a href="{{ $entity->url() }}">
                @if ($model->is_private)
                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                @endif
                {{ $entity->name }}
            </a>

        </h3>
    </div>
    <div class="panel-body">
        @if ($widget->conf('full') === '1')
            {!! $model->entry() !!}
        @else
        <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">
            {!! $model->entry() !!}
        </div>
        <a href="#" class="preview-switch hidden"
           id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
            <i class="fa fa-chevron-down"></i>
        </a>
        @endif
    </div>
</div>
@endif
