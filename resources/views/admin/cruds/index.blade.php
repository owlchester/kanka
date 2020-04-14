@extends('layouts.admin', [
    'title' => trans($trans . '.index.title'),
    'breadcrumbs' => [
        ['url' => route($route . '.index'), 'label' => trans($trans . '.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    <div class="row margin-bottom">
        <div class="col-md-12">
            @include('layouts.datagrid.search', ['route' => route($route . '.index')])

            @if ($createAction)
                <a href="{{ route($route . '.create') }}" class="btn btn-primary pull-right">
                    <i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">{{ trans($trans . '.index.add') }}</span>
                </a>
            @endif
            @foreach ($actions as $action)
                <a href="{{ route($route . '.index', $action['params']) }}" class="btn btn-default">
                    <i class="{{ $action['icon'] }}"></i> {{ $action['text'] }}
                </a>
            @endforeach
        </div>
    </div>

    @include('partials.errors')

    <div class="box no-border">
        <div class="box-body no-padding">
            @include($name . '.datagrid')
        </div>
        <div class="box-footer">
            <div class="pull-right">
                {{ $models->appends($filterService->pagination())->links() }}
            </div>
            {!! Form::hidden('entity', $name) !!}
        </div>
    </div>
@endsection
