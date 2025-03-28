<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/dashboard-header.edit.title', ['name' => $campaign->name]),
    'breadcrumbs' => [],
    'mainTitle' => false,
])

@section('content')

    <x-form :action="['campaigns.dashboard-header.update', $campaign, $campaign]" method="PATCH" files class="entity-form">
        @include('partials.forms._dialog', [
            'title' => __('campaigns/dashboard-header.edit.title'),
            'content' => 'campaigns.forms.dashboard-header._form',
            'deleteID' => !empty($widget) ? '#delete-widget-' . $widget->id : null,
        ])
    </x-form>

    @if (!empty($widget))
        <x-form method="DELETE" :action="['campaign_dashboard_widgets.destroy', $campaign, $widget]" id="delete-widget-{{ $widget->id }}" />
    @endif
@endsection
