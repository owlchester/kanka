<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Character $model
 * @var \App\Models\Quest $model
 */
$model = $entity->child;
?>
<div class="panel panel-default widget-preview" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading @if ($widget->conf('entity-header') && $campaign->boosted() && $entity->header_image) panel-heading-entity" style="background-image: url({{ $entity->getImageUrl(0, 0, 'header_image') }}) @elseif ($model->image) panel-heading-entity" style="background-image: url({{ $model->getImageUrl() }}) @endif">
        <h3 class="panel-title">
            <a href="{{ $model->getLink() }}">
                @if ($model->is_private)
                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                @endif
                @if ($model->is_completed)
                    <i class="fa fa-check-circle pull-right margin-r-5" title="{{ trans('quests.fields.is_completed') }}"></i>
                @endif
                {{ $entity->name }}
            </a>

        </h3>
    </div>
    <div class="panel-body">
        @if ($widget->conf('full') === '1')
            <dl class="dl-horizontal">
                @if ($campaign->enabled('characters') && !empty($model->character))
                    <dt>{{ __('quests.fields.character') }}</dt>
                    <dd>
                        {!! $model->character->tooltipedLink() !!}
                    </dd>
                @endif
            </dl>

            {!! $model->entry() !!}
        @else
        <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">

            <dl class="dl-horizontal">
                @if ($campaign->enabled('characters') && !empty($model->character))
                    <dt>{{ __('quests.fields.character') }}</dt>
                    <dd>
                        {!! $model->character->tooltipedLink() !!}
                    </dd>
                @endif
            </dl>

            {!! $model->entry() !!}
        </div>
        <a href="#" class="preview-switch hidden"
           id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
            <i class="fa fa-chevron-down"></i>
        </a>
        @endif
    </div>
</div>
