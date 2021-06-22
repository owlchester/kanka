@extends('layouts.app', [
    'title' => trans('attribute_templates.attribute_templates.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('attribute_templates.index'), 'label' => __('attribute_templates.index.title')],
        ['url' => route('attribute_templates.show', $model), 'label' => $model->name],
        trans('attribute_templates.show.tabs.attribute_templates')
    ],
    'canonical' => true,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('attribute_templates._menu', ['active' => 'attribute_templates'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('attribute_templates.panels.attribute_templates')
        </div>
    </div>
@endsection
