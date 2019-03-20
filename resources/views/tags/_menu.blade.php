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
            @if (!empty($model->tag))
                <li class="list-group-item">
                    <b>{{ trans('crud.fields.tag') }}</b>

                    <span class="pull-right">
                            <a href="{{ route('tags.show', $model->tag->id) }}" data-toggle="tooltip" title="{{ $model->tag->tooltip() }}">{{ $model->tag->name }}</a>
                                @if ($model->tag->tag)
                            , <a href="{{ route('tags.show', $model->tag->tag->id) }}" data-toggle="tooltip" title="{{ $model->tag->tag->tooltip() }}">{{ $model->tag->tag->name }}</a>
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