@php
$plural = \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'));
@endphp
@extends('layouts.app', [
    'title' => $model->name . ' - ' . $plural,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('entity-header-actions')
    @include('characters.panels._buttons')
@endsection

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('characters'), 'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters'))],
                $plural
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'organisations'])

        <div class="entity-main-block">
            @include('characters.panels.organisations')
        </div>
    </div>
@endsection
