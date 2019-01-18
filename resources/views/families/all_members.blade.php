@extends('layouts.app', [
    'title' => trans('families.members.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('families.index'), 'label' => __('families.index.title')],
        ['url' => route('families.show', $model), 'label' => $model->name],
        trans('families.show.tabs.members')
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('families._menu', ['active' => 'all_members'])
        </div>
        <div class="col-md-9">
            @include('families.panels.all_members')
        </div>
    </div>
@endsection
