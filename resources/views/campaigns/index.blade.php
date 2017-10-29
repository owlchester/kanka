@extends('layouts.app', ['title' => trans('campaigns.title'), 'description' => trans('campaigns.description')])

@section('content')
        <div class="row">
            @foreach ($campaigns as $campaign)
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{!! $campaign->shortName() !!}</h3>

                            <p>Short description?</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-map"></i>
                        </div>
                        <a href="{{ route('campaigns.index', ['campaign_id' => $campaign->id]) }}" class="small-box-footer">
                            Select <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>New Campaign</h3>
                            <p><br /></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-plus"></i>
                        </div>
                        <a href="{{ route('campaigns.create') }}" class="small-box-footer">
                            Create a new campaign <i class="fa fa-plus-circle"></i>
                        </a>
                    </div>
                </div>


            </div>
        </div>
@endsection
