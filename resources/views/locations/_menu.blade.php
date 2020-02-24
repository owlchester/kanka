<?php /** @var App\Models\location $location */ ?>
@inject('campaign', 'App\Services\CampaignService')
<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
        @include ('cruds._image')

        <h1 class="profile-username text-center">{{ $model->name }}
            @if ($model->is_private)
                <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h1>
        @endif

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
                        {!! $model->parentLocation->tooltipedLink() !!}@if ($model->parentLocation->parentLocation),
                        {!! $model->parentLocation->parentLocation->tooltipedLink() !!}
                        @endif
                            </span>
                    <br class="clear" />
                </li>
            @endif
            @include('entities.components.relations')
            @include('entities.components.attributes')
            @include('entities.components.tags')
        </ul>
    </div>
</div>

@include('entities.components.menu')
@include('entities.components.actions')
