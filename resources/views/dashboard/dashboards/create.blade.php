@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('dashboard.dashboards.create.title'),
    'description' => '',
    'breadcrumbs' => []
])

@section('content')

    <x-form :action="['campaign_dashboards.store', $campaign]">
    @include('partials.forms._dialog', [
        'title' => __('dashboard.dashboards.create.title'),
        'content' => 'dashboard.dashboards._form',
    ])
    </x-form>
@endsection
