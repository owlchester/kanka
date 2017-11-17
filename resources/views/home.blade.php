@extends('layouts.app', ['title' => trans('dashboard.title'), 'description' => trans('dashboard.description')])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{!! $campaign->shortName() !!}</h3>

                    <p>{!! trans('campaigns.members.your_role', ['role' => trans('campaigns.members.roles.' . $campaign->role())]) !!}</p>
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
        @if ($campaign->enabled('characters'))
            @include('dashboard._recent', ['title' => 'Characters', 'route' => 'characters', 'models' => $characters])
        @endif
        @if ($campaign->enabled('families'))
            @include('dashboard._recent', ['title' => 'Families', 'route' => 'families', 'models' => $families])
        @endif
        @if ($campaign->enabled('locations'))
            @include('dashboard._recent', ['title' => 'Locations', 'route' => 'locations', 'models' => $locations])
        @endif
        @if ($campaign->enabled('organisations'))
            @include('dashboard._recent', ['title' => 'Organisations', 'route' => 'organisations', 'models' => $organisations])
        @endif
        @if ($campaign->enabled('items'))
            @include('dashboard._recent', ['title' => 'Items', 'route' => 'items', 'models' => $items])
        @endif
        @if ($campaign->enabled('journals'))
            @include('dashboard._recent', ['title' => 'Journals', 'route' => 'journals', 'models' => $journals])
        @endif
    </div>
@endsection
