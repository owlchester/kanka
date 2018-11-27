@extends('layouts.admin', [
    'title' => __('admin/home.title'),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('admin.home'), 'label' => __('admin/home.title')]
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
                    <span class="progress-description"><?=\App\User::today()->count()?> created today, <?=\App\User::startOfMonth()->count()?> created this month</span>
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


    @include('partials.errors')

    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Top Users (Logins)</h4>
                </div>
                <div class="box-body no-padding">
                    <dl class="dl-horizontal">
                    @foreach (\App\User::top()->limit(5)->get() as $user)
                        <dt>{{ $user->cpt }}</dt>
                        <dd>{{ $user->name }}</dd>
                    @endforeach
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Top Campaigns (Entities)</h4>
                    <div class="box-body no-padding">
                        <dl class="dl-horizontal">
                            @foreach (\App\Models\Campaign::top()->limit(5)->get() as $campaign)
                                <dt>{{ $campaign->cpt }}</dt>
                                <dd>{{ $campaign->name }}</dd>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Top Campaigns (Users)</h4>
                    <div class="box-body no-padding">
                        <dl class="dl-horizontal">
                            @foreach (\App\Models\Campaign::topMembers()->limit(5)->get() as $campaign)
                                <dt>{{ $campaign->cpt }}</dt>
                                <dd>{{ $campaign->name }}</dd>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection
