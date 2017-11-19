@extends('layouts.app', [
    'title' => trans($name . '.index.title', ['name' => Auth::user()->campaign->name]),
    'description' => trans($name . '.index.description',  ['name' => Auth::user()->campaign->name]),
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
                    @endif
                    @foreach ($actions as $action)
                        @if (empty($action['policy']) || Auth::user()->can($action['policy'], $model))
                            <a href="{{ $action['route'] }}" class="btn btn-sm {{ $action['class'] }}">
                                {!! $action['label'] !!}
                            </a>
                        @endif
                    @endforeach
                    <br>

                    <div class="box-tools">

                        @include('layouts.datagrid.search', ['route' => route($name . '.index')])
                    </div>
                </div>

                <div class="box-body no-padding">
                    @include($name . '.datagrid')
                </div>
                <div class="box-footer">
                    {{ $models->appends('order', request()->get('order'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
