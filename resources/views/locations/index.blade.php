@extends('layouts.app', [
    'title' => trans('locations.index.title'),
    'description' => trans('locations.index.description'),
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    @if (Auth::user()->can('create', \App\Location::class))
                    <a href="{{ route('locations.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ trans('locations.index.add') }}
                    </a>
                    @else
                        <br>
                    @endif

                    <div class="box-tools">

                        @include('layouts.datagrid.search', ['route' => route('locations.index')])
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    @include('locations.datagrid')
                    {{ $models->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
