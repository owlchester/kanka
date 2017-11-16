@extends('layouts.app', [
    'title' => trans($name . '.index.title'),
    'description' => trans($name . '.index.description'),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    @if (Auth::user()->can('create', $model))
                    <a href="{{ route($name . '.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ trans($name . '.index.add') }}
                    </a>
                    @else
                        <br>
                    @endif

                    <div class="box-tools">

                        @include('layouts.datagrid.search', ['route' => route($name . '.index')])
                    </div>
                </div>

                <div class="box-body no-padding">
                    @include($name . '.datagrid')
                </div>
            </div>
        </div>
    </div>
@endsection
