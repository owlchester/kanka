@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('dashboard.dashboards.update.title', ['name' => $dashboard->name]),
    'description' => '',
    'breadcrumbs' => []
])

@section('content')
    <x-form :action="['campaign_dashboards.update', $campaign, $dashboard]" method="PATCH">
        @include('partials.forms._dialog', [
            'title' => __('dashboard.dashboards.update.title', ['name' => $dashboard->name]),
            'content' => 'dashboard.dashboards._form',
        ])
    </x-form>
@endsection
