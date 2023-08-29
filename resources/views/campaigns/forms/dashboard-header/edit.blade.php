<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/dashboard-header.edit.title', ['name' => $campaign->name]),
    'breadcrumbs' => [],
    'mainTitle' => false,
])

@section('content')

    {!! Form::model($campaign, [
        'method' => 'PATCH',
        'route' => ['campaigns.dashboard-header.update', [$campaign, $campaign]],
        'data-shortcut' => 1,
        'class' => 'entity-form',
        'enctype' => 'multipart/form-data',
    ]) !!}

    @include('partials.forms.form', [
        'dialog' => true,
        'title' => __('campaigns/dashboard-header.edit.title'),
        'content' => 'campaigns.forms.dashboard-header._form',
        'deleteID' => !empty($widget) ? '#delete-widget-' . $widget->id : null,
    ])

    {!! Form::close() !!}

    @if (!empty($widget))
        {!! Form::open(['method' => 'DELETE','route' => ['campaign_dashboard_widgets.destroy', [$campaign, $widget]], 'class' => 'form-inline', 'id' => 'delete-widget-' . $widget->id]) !!}
        {!! Form::close() !!}
    @endif
@endsection
