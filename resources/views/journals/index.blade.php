@extends('layouts.app', [
    'title' => trans('journals.index.title'),
    'description' => trans('journals.index.description'),
    'breadcrumbs' => [
        ['url' => route('journals.index'), 'label' => trans('journals.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    @if (Auth::user()->can('create', \App\Journal::class))
                    <a href="{{ route('journals.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ trans('journals.index.add') }}
                    </a>
                    @else
                        <br>
                    @endif

                    <div class="box-tools">

                        @include('layouts.datagrid.search', ['route' => route('journals.index')])
                    </div>
                </div>

                <div class="box-body no-padding">
                    @include('journals.datagrid')
                </div>
            </div>
        </div>
    </div>
@endsection
