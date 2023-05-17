@php
$plural = \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' - ' . $plural,
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('races'), 'label' => \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races'))],
        ['url' => $model->getLink(), 'label' => $model->name],
        $plural
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('entities.components.menu_v2', ['active' => 'characters'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('races.panels.characters')
        </div>
    </div>
@endsection
