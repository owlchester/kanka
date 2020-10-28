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
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Accounts</span>
                    <span class="info-box-number">{{ number_format(\App\User::count(), 0, '.', '\'') }}</span>
                    <span class="progress-description">{{ number_format(\App\User::today()->count(), 0, '.', '\'') }} created today,
                        {{ number_format(\App\User::startOfMonth()->count(), 0, '.', '\'') }} created this month</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-globe"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Campaigns</span>
                    <span class="info-box-number">{{ number_format(\App\Models\Campaign::count(), 0, '.', '\'') }}</span>
                    <span class="progress-description">{{ number_format(\App\Models\Campaign::today()->count(), 0, '.', '\'') }} created today</span>
                </div>
            </div>
        </div>
    </div>


    @include('partials.errors')

    <div class="row">
        <div class="col-md-4">
            @if ($advanced)
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Top Users (Logins)</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                    @foreach (\App\User::top()->limit(5)->get() as $user)
                        <div class="col-xs-8 text-right">
                            {{ $user->name }}
                        </div>
                        <div class="col-xs-4 text-bold">
                            {{ number_format($user->cpt, 0, '.', '\'') }}
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Themes</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach (\App\User::themes()->get() as $theme)
                            <div class="col-xs-8 text-right">
                                {{ $theme->theme ?: 'Default' }}
                            </div>
                            <div class="col-xs-4 text-bold">
                                {{ number_format($theme->cpt, 0, '.', '\'') }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if ($advanced)
        <div class="col-md-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Top Campaigns (Entities)</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach (\App\Models\Campaign::top()->limit(7)->get() as $campaign)
                            <div class="col-xs-8 text-right">
                                {{ link_to(app()->getLocale() . '/' . $campaign->getMiddlewareLink(), $campaign->name) }}
                            </div>
                            <div class="col-xs-4 text-bold">
                                {{ number_format($campaign->cpt, 0, '.', '\'') }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Top Campaigns (Users)</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach (\App\Models\Campaign::topMembers()->limit(5)->get() as $campaign)
                            <div class="col-xs-8 text-right">
                                {{ link_to(app()->getLocale() . '/' . $campaign->getMiddlewareLink(), $campaign->name) }}
                            </div>
                            <div class="col-xs-4 text-bold">
                                {{ $campaign->cpt }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Total Entities</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach (\App\Models\Entity::top()->get() as $entity)
                            <div class="col-xs-8 text-right">
                                {{ $entity->type }}
                            </div>
                            <div class="col-xs-4 text-bold">
                                {{ number_format($entity->cpt, 0, '.', '\'') }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            @if ($advanced)
            <a class="btn btn-primary" href="{{ route('admin.home') }}">Simple Stats</a>
            @else
            <a class="btn btn-primary" href="{{ route('admin.home', ['advanced' => 1]) }}">Advanced Stats</a>
            @endif
        </div>
    </div>
@endsection
