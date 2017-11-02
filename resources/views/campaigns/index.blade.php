@extends('layouts.app', [
    'title' => trans('campaigns.title'),
    'description' => trans('campaigns.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.title')]
    ]
])

@section('content')
    <div class="row">
        @foreach ($campaigns as $c)
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h2>{!! $c->shortName() !!}</h2>

                    </div>
                    <div class="icon">
                        <i class="ion ion-map"></i>
                    </div>
                    <a href="{{ route('campaigns.index', ['campaign_id' => $c->id]) }}" class="small-box-footer">
                        Select <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endforeach

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h2>New Campaign</h2>
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

    @if ($campaign)
        @include('campaigns.show')
    @endif
@endsection
