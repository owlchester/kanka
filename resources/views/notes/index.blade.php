@extends('layouts.app', [
    'title' => trans('notes.index.title'),
    'description' => trans('notes.index.description'),
    'breadcrumbs' => [
        ['url' => route('notes.index'), 'label' => trans('notes.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    @if (Auth::user()->can('create', \App\Item::class))
                    <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ trans('notes.index.add') }}
                    </a>
                    @else
                        <br>
                    @endif

                    <div class="box-tools">

                        @include('layouts.datagrid.search', ['route' => route('notes.index')])
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    @include('notes.datagrid')

                    {{ $models->appends('order', request()->get('order'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
