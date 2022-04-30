<?php /** @var \App\Models\Campaign $model */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('campaigns/dashboard-header.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [],
    'mainTitle' => false,
])

@inject('campaign', 'App\Services\CampaignService')
@section('content')

    {!! Form::model($model, [
'method' => 'PATCH',
'route' => ['campaigns.dashboard-header.update', $model],
'data-shortcut' => 1,
'class' => 'entity-form',
'enctype' => 'multipart/form-data',
]) !!}

    <div class="modal-default">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! __('campaigns/dashboard-header.edit.title') !!}</h4>
            </div>
        <div class="modal-body">
            @include('partials.errors')

            @include('campaigns.forms.dashboard-header._form')

        </div>
        <div class="modal-footer">
            @include('cruds.fields.save', ['onlySave' => true])
            {!! Form::close() !!}

            @if (!empty($widget))
            <div class="pull-left">
                {!! Form::open(['method' => 'DELETE','route' => ['campaign_dashboard_widgets.destroy', $widget], 'class' => 'form-inline']) !!}
                <button class="btn btn-danger">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> <span class="hidden-xs hidden-md">{{ trans('crud.remove') }}</span>
                </button>
                {!! Form::close() !!}
            </div>
            @endif
        </div>
    </div>
@endsection
