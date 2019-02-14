<?php /** @var App\Models\Tag $location */ ?>
@inject('campaign', 'App\Services\CampaignService')

<div class="box box-solid">
    <div class="box-body box-profile">
        @include ('cruds._image')

        <h3 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
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

@if (!isset($exporting))
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('crud.tabs.menu') }}
            </h3>
        </div>
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
                <li class="@if(empty($active))active @endif">
                    <a href="{{ route('tags.show', $model) }}">
                        {{ __('crud.panels.entry') }}
                    </a>
                </li>
                @if (($count = $model->descendants()->acl()->count()) > 0)
                    <li class="@if(!empty($active) && $active == 'tags')active @endif">
                        <a href="{{ route('tags.tags', $model) }}">
                            {{ __('tags.show.tabs.tags') }}
                            <span class="label label-default pull-right">
                        <?=$count?>
                    </span>
                        </a>
                    </li>
                @endif

                @if (($count = $model->allChildren()->acl()->count()) > 0)
                    <li class="@if(!empty($active) && $active == 'children')active @endif">
                        <a href="{{ route('tags.children', $model) }}">
                            {{ __('tags.show.tabs.children') }}
                            <span class="label label-default pull-right">
                        <?=$count?>
                    </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif