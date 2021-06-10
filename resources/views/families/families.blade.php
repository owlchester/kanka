@extends('layouts.app', [
    'title' => trans('families.families.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('families'), 'label' => __('families.index.title')],
        ['url' => route('families.show', $model), 'label' => $model->name],
        trans('families.show.tabs.families')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include('families._menu', ['active' => 'families'])
        </div>
        <div class="col-md-10">
            @include('families.panels.families')
        </div>
    </div>
@endsection
