@extends('layouts.app', [
    'title' => trans('items.index.title'),
    'description' => trans('items.index.description'),
    'breadcrumbs' => [
        ['url' => route('items.index'), 'label' => trans('items.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    @if (Auth::user()->can('create', \App\Item::class))
                    <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ trans('items.index.add') }}
                    </a>
                    @else
                        <br>
                    @endif

                    <div class="box-tools">

                        @include('layouts.datagrid.search', ['route' => route('items.index')])
                    </div>
                </div>

                <div class="box-body no-padding">
                    @include('items.datagrid')

                    {{ $models->appends('order', request()->get('order'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
