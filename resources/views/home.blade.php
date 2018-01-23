@extends('layouts.app', [
    'title' => trans('dashboard.title'),
    'description' => trans('dashboard.description')
])

@section('content')

    <a href="{{ route('dashboard.settings') }}" class="btn btn-default btn-xl pull-right" title="{{ trans('dashboard.settings.title') }}"><i class="fa fa-cog"></i></a>

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
        @if ($campaign->enabled('characters') && $settings->has('characters'))
            @include('dashboard._recent', ['title' => trans('entities.characters'), 'route' => 'characters', 'models' => $characters])
        @endif
        @if ($campaign->enabled('families') && $settings->has('families'))
            @include('dashboard._recent', ['title' => trans('entities.families'), 'route' => 'families', 'models' => $families])
        @endif
        @if ($campaign->enabled('locations') && $settings->has('locations'))
            @include('dashboard._recent', ['title' => trans('entities.locations'), 'route' => 'locations', 'models' => $locations])
        @endif
        @if ($campaign->enabled('organisations') && $settings->has('organisations'))
            @include('dashboard._recent', ['title' => trans('entities.organisations'), 'route' => 'organisations', 'models' => $organisations])
        @endif
        @if ($campaign->enabled('items') && $settings->has('items'))
            @include('dashboard._recent', ['title' => trans('entities.items'), 'route' => 'items', 'models' => $items])
        @endif
        @if ($campaign->enabled('journals') && $settings->has('journals'))
            @include('dashboard._recent', ['title' => trans('entities.journals'), 'route' => 'journals', 'models' => $journals])
        @endif
    </div>
@endsection
