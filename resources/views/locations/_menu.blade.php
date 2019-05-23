<?php /** @var App\Models\location $location */ ?>
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
                    <b>{{ trans('locations.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if (!empty($model->parentLocation))
                <li class="list-group-item">
                    <b title="{{ trans('crud.fields.location') }}">
                        <i class="ra ra-tower"></i> <span class="visible-xs-inline">{{ trans('locations.fields.location') }}</span>
                    </b>

                    <span class="pull-right">
                            <a href="{{ route('locations.show', $model->parentLocation->id) }}" data-toggle="tooltip" title="{{ $model->parentLocation->tooltipWithName() }}" data-html="true">{{ $model->parentLocation->name }}</a>@if ($model->parentLocation->parentLocation),
                        <a href="{{ route('locations.show', $model->parentLocation->parentLocation->id) }}" data-toggle="tooltip" title="{{ $model->parentLocation->parentLocation->tooltipWithName() }}" data-html="true">{{ $model->parentLocation->parentLocation->name }}</a>
                        @endif
                            </span>
                    <br class="clear" />
                </li>
            @endif
            @include('entities.components.tags')
            @include('entities.components.files')
        </ul>
        @include('.cruds._actions')
    </div>
</div>

@include('entities.components.menu')
