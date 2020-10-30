@extends('layouts.app', [
    'title' => trans('campaigns/stats.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => trans('campaigns.index.title')],
        __('campaigns.show.tabs.stats')
    ],
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'stats'])
        </div>
        <div class="col-md-9">
            <div class="box no-border">
                <div class="box-body">
                    <p class="help-block">{{ __('campaigns/stats.helper') }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-lg-6 col-xl-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua">
                            <i class="fa fa-users" title="{{ __('entities.characters') }}"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ \Illuminate\Support\Arr::get($stats, 'characters.title') }}</span>
                            <span class="info-box-number">{{ __('campaigns/stats.placeholder', [
                                'amount' => \Illuminate\Support\Arr::get($stats, 'characters.amount'),
                                'target' => \Illuminate\Support\Arr::get($stats, 'characters.target')
                            ]) }} <small>{{ __('entities.characters') }}</small></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 col-xl-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua">
                            <i class="ra ra-tower" title="{{ __('entities.locations') }}"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ \Illuminate\Support\Arr::get($stats, 'locations.title') }}</span>
                            <span class="info-box-number">{{ __('campaigns/stats.placeholder', [
                                'amount' => \Illuminate\Support\Arr::get($stats, 'locations.amount'),
                                'target' => \Illuminate\Support\Arr::get($stats, 'locations.target')
                            ]) }} <small>{{ __('entities.locations') }}</small></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 col-xl-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua">
                            <i class="ra ra-wyvern" title="{{ __('entities.races') }}"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ \Illuminate\Support\Arr::get($stats, 'races.title') }}</span>
                            <span class="info-box-number">{{ __('campaigns/stats.placeholder', [
                                'amount' => \Illuminate\Support\Arr::get($stats, 'races.amount'),
                                'target' => \Illuminate\Support\Arr::get($stats, 'races.target')
                            ]) }} <small>{{ __('entities.races') }}</small></span>
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div class="row">
                @foreach ($stats['achievements'] as $achievement)
                <div class="col-sm-6 col-lg-6 col-xl-4">
                    <div class="info-box">
                        <span class="info-box-icon @if($achievement['score'] === 1) bg-green @else bg-grey @endif">
                            <i class="{{ \Illuminate\Support\Arr::get($achievement, 'icon') }}"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ \Illuminate\Support\Arr::get($achievement, 'title') }}</span>
                            <span class="info-box-number">{{ __('campaigns/stats.placeholder', [
                                'amount' => \Illuminate\Support\Arr::get($achievement, 'amount', 0),
                                'target' => \Illuminate\Support\Arr::get($achievement, 'target', 100)
                            ]) }} <small>{{ \Illuminate\Support\Arr::get($achievement, 'goal') }}</small></span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

