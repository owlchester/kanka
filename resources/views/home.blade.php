@extends('layouts.app', ['title' => trans('dashboard.title'), 'description' => trans('dashboard.description')])

@section('content')
    <div class="row">
        <div class="col-md-0 col-sm-4 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{!! $campaign->shortName() !!}</h3>

                    <p>The current campaign</p>
                </div>
                <div class="icon">
                    <i class="ion ion-map"></i>
                </div>
                <a class="small-box-footer" href="{{ route('campaigns.index') }}">
                    <i class="fa fa-arrow-circle-right"></i> Manage campaigns
                </a>
            </div>
        </div>
    </div>
@endsection
