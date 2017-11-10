@extends('layouts.app', [
    'title' => trans('organisations.index.title'),
    'description' => trans('organisations.index.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    @if (Auth::user()->can('create', \App\Organisation::class))
                    <a href="{{ route('organisations.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ trans('organisations.index.add') }}
                    </a>
                    @else
                        <br>
                    @endif

                    <div class="box-tools">

                        @include('layouts.datagrid.search', ['route' => route('organisations.index')])
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    @include('organisations.datagrid')

                    {{ $models->appends('order', request()->get('order'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
