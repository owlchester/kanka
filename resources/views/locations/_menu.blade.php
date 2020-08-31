<?php /** @var App\Models\location $location */ ?>
@inject('campaign', 'App\Services\CampaignService')
<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!View::hasSection('entity-header'))
        @include ('cruds._image')
        @endif

        <ul class="list-group list-group-unbordered">
            @if (!empty($model->type))
                <li class="list-group-item">
                    <b>{{ __('locations.fields.type') }}</b> <span class="pull-right clear">{{ $model->type }}</span>
                    <br class="clear" />
                </li>
            @endif
            @if (!empty($model->parentLocation))
                <li class="list-group-item">
                    <b title="{{ __('crud.fields.location') }}">
                        <i class="ra ra-tower"></i> <span class="visible-xs-inline">{{ __('locations.fields.location') }}</span>
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
