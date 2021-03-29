<?php /** @var \App\Models\Campaign $model */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('campaigns/dashboard-header.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [],
    'mainTitle' => false,
])

@inject('campaign', 'App\Services\CampaignService')
@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>{!! __('campaigns/dashboard-header.edit.title') !!}</h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($model, [
    'method' => 'PATCH',
    'route' => ['campaigns.dashboard-header.update', $model],
    'data-shortcut' => 1,
    'class' => 'entity-form',
    'enctype' => 'multipart/form-data',
]) !!}

            @include('campaigns.forms.dashboard-header._form')

            <div class="row">
                <div class="col-xs-6">

                    @include('cruds.fields.save', ['onlySave' => true])
                    {!! Form::close() !!}
                </div>
                <div class="col-xs-6 text-right">
                    @if (!empty($widget))
                        {!! Form::open(['method' => 'DELETE','route' => ['campaign_dashboard_widgets.destroy', $widget], 'class' => 'form-inline']) !!}
                        <button class="btn btn-danger">
                            <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs hidden-md">{{ trans('crud.remove') }}</span>
                        </button>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
