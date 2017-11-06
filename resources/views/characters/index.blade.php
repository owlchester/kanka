@extends('layouts.app', [
    'title' => trans('characters.index.title'),
    'description' => trans('characters.index.description', ['name' => $campaign->name()]),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => trans('characters.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <a href="{{ route('characters.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ trans('characters.index.add') }}
                    </a>

                    <div class="box-tools">
                        @include('layouts.datagrid.search', ['route' => route('characters.index')])
                    </div>
                </div>
                <div class="box-body no-padding">

                    @include('characters.datagrid')

                    {{ $models->appends('order', request()->get('order'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
