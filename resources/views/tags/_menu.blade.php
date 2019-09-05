<?php /** @var App\Models\Tag $location */ ?>
@inject('campaign', 'App\Services\CampaignService')

<div class="box box-solid">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>

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
            @include('entities.components.files')
        </ul>
        @include('.cruds._actions')
    </div>
</div>

@include('entities.components.menu')