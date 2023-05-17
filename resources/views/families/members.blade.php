@extends('layouts.app', [
    'title' => $model->name . ' - ' . \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('families'), 'label' => \App\Facades\Module::plural(config('entities.ids.family'), __('entities.families'))],
                null
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'members'])

        <div class="entity-main-block">
            @include('families.panels._members')
        </div>
    </div>
@endsection
