<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('campaigns/dashboard-header.edit.title', ['name' => $campaign->name]),
    'breadcrumbs' => [],
    'mainTitle' => false,
])

@inject('campaignService', 'App\Services\CampaignService')
@section('content')

    {!! Form::model($campaign, [
        'method' => 'PATCH',
        'route' => ['dashboard-header.update', [$campaign]],
        'data-shortcut' => 1,
        'class' => 'entity-form',
        'enctype' => 'multipart/form-data',
    ]) !!}

    @include('partials.forms.form', [
        'title' => __('campaigns/dashboard-header.edit.title'),
        'content' => 'campaigns.forms.dashboard-header._form',
        'deleteID' => !empty($widget) ? '#delete-widget-' . $widget->id : null
    ])

    {!! Form::close() !!}

    @if (!empty($widget))
        {!! Form::open(['method' => 'DELETE','route' => ['campaign_dashboard_widgets.destroy', $widget], 'class' => 'form-inline', 'id' => 'delete-widget-' . $widget->id]) !!}
        {!! Form::close() !!}
    @endif
@endsection
