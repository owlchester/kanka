@extends('layouts.admin', [
    'title' => trans('admin.home.title'),
    'description' => trans('admin.home.description'),
    'breadcrumbs' => [
        ['url' => route('admin.home'), 'label' => trans('admin.home.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Accounts</span>
                    <span class="info-box-number"><?=\App\User::count()?></span>
                    <span class="progress-description"><?=\App\User::today()->count()?> created today</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-globe"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Campaigns</span>
                    <span class="info-box-number"><?=\App\Models\Campaign::count()?></span>
                    <span class="progress-description"><?=\App\Models\Campaign::today()->count()?> created today</span>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">

        </div>

        @include('partials.errors')

        <div class="box-body no-padding">
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection
