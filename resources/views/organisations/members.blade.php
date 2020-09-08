@extends('layouts.app', [
    'title' => trans('organisations.members.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => __('organisations.index.title')],
        ['url' => route('organisations.show', $model), 'label' => $model->name],
        trans('organisations.fields.members')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('organisations._menu', ['active' => 'members'])
        </div>
        <div class="col-md-9">
            @include('organisations.panels.members')
        </div>
    </div>
@endsection
