<?php /** @var App\Models\Tag $location */ ?>
@inject('campaign', 'App\Services\CampaignService')

<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
            @include ('cruds._image')
        @endif

        <ul class="list-group list-group-unbordered">
            @if (!empty($model->type))
                <li class="list-group-item">
                    <b>{{ trans('tags.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if ($model->hasColour())
                <li class="list-group-item">
                    <b>{{ __('calendars.fields.colour') }}</b>
                    <span class="pull-right clear {{ $model->colourClass() }}">{{ __('colours.' . $model->colour) }}</span>
                </li>
            @endif
            @if (!empty($model->tag))
                <li class="list-group-item">
                    <b>{{ trans('crud.fields.tag') }}</b>

                    <span class="pull-right">
                        {!! $model->tag->tooltipedLink() !!}
                        @if ($model->tag->tag)
                            {!! $model->tag->tag->tooltipedLink() !!}
                        @endif
                            </span>
                    <br class="clear" />
                </li>
            @endif
            @include('entities.components.attributes')
        </ul>
    </div>
</div>

@include('entities.components.menu')
@include('entities.components.actions')
