@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('dashboard.dashboards.create.title'),
    'description' => '',
    'breadcrumbs' => []
])

@section('content')

    <x-form :action="['campaign_dashboards.store', $campaign]">
    @include('partials.forms.form', [
        'dialog' => true,
        'title' => __('dashboard.dashboards.create.title'),
        'content' => 'dashboard.dashboards._form',
        'dialog' => true,
    ])
    </x-form>
@endsection
