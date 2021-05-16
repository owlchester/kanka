@extends('layouts.app', [
    'title' => __('characters.profile.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => __('characters.index.title')],
        ['url' => route('characters.show', $model), 'label' => $model->name],
        __('characters.show.tabs.profile')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons">
            <a href="{{ $model->getLink('update') }}" class="btn btn-primary">
                {{ __('characters.actions.edit_profile') }}
            </a>
        </div>
    @endcan
@endsection

@include('entities.components.header', ['model' => $model])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include('characters._menu', ['active' => 'profile'])
        </div>
        <div class="col-md-10">
            @include('characters.panels.profile')
        </div>
    </div>
@endsection


