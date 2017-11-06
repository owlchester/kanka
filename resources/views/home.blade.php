@extends('layouts.app', ['title' => trans('dashboard.title'), 'description' => trans('dashboard.description')])

@section('content')
    <div class="row">
        <div class="col-md-0 col-sm-4 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{!! $campaign->shortName() !!}</h3>

                    <p>{{ trans('dashboard.campaigns.current') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-map"></i>
                </div>
                <a class="small-box-footer" href="{{ route('campaigns.index') }}">
                    <i class="fa fa-arrow-circle-right"></i> {{ trans('dashboard.campaigns.manage') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        @include('dashboard._recent', ['title' => 'Characters', 'route' => 'characters', 'models' => $characters])
        @include('dashboard._recent', ['title' => 'Families', 'route' => 'families', 'models' => $families])
        @include('dashboard._recent', ['title' => 'Locations', 'route' => 'locations', 'models' => $locations])
    </div>
    <div class="row">
        @include('dashboard._recent', ['title' => 'Organisations', 'route' => 'organisations', 'models' => $organisations])
        @include('dashboard._recent', ['title' => 'Items', 'route' => 'items', 'models' => $items])
        @include('dashboard._recent', ['title' => 'Journals', 'route' => 'journals', 'models' => $journals])
    </div>
@endsection
