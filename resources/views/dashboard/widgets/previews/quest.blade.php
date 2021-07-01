<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Character $model
 * @var \App\Models\Quest $model
 */
$model = $entity->child;
?>
<div class="panel panel-default widget-preview" id="dashboard-widget-{{ $widget->id }}">
    <div
    @if ($widget->conf('entity-header') && $campaign->boosted() && $entity->header_image)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ $entity->getImageUrl(1200, 400, 'header_image') }}')"
    @elseif ($widget->conf('entity-header') && $campaign->boosted(true) && $widget->entity->header)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ Img::crop(1200, 400)->url($widget->entity->header->path) }}')"
    @elseif ($entity->child->image)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ $entity->child->getImageUrl() }}')"
    @elseif($campaign->boosted(true) && !empty($entity->image))
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ Img::crop(1200, 400)->url($entity->image->path) }}')"
    @else
        class="panel-heading"
    @endif
    >
        <h3 class="panel-title">
            <a href="{{ $model->getLink() }}">
                @if ($model->is_private)
                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                @endif
                @if ($model->is_completed)
                    <i class="fa fa-check-circle pull-right margin-r-5" title="{{ trans('quests.fields.is_completed') }}"></i>
                @endif

                @if(!empty($customName))
                    {{ $customName }}
                @elseif (!empty($widget->conf('text')))
                    {{ $widget->conf('text') }}
                @else
                    {{ $entity->name }}
                @endif
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

            <div class="entity-content">
            {!! $model->entry() !!}
            </div>

            @include('dashboard.widgets.previews._members')
            @include('dashboard.widgets.previews._attributes')
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

            <div class="entity-content">
            {!! $model->entry() !!}
            </div>

            @include('dashboard.widgets.previews._members')
            @include('dashboard.widgets.previews._attributes')
        </div>
        <a href="#" class="preview-switch hidden"
           id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
            <i class="fa fa-chevron-down"></i>
        </a>
        @endif
    </div>
</div>
