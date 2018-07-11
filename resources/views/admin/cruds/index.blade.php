@extends('layouts.admin', [
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
                    @foreach ($actions as $action)
                        @if (empty($action['policy']) || (Auth::check() && Auth::user()->can($action['policy'], $model)))
                            <a href="{{ $action['route'] }}" class="btn btn-sm btn-{{ $action['class'] }}">
                                {!! $action['label'] !!}
                            </a>
                        @endif
                    @endforeach
                    <br>

                    <div class="box-tools">
                        @include('layouts.datagrid.search', ['route' => route($name . '.index')])
                    </div>
                </div>

                @include('partials.errors')
                @include('cruds._filters', ['route' => route($name . '.index'), 'filters' => $filters, 'filterService' => $filterService, 'name' => $name])

                <div class="box-body no-padding">
                    @include($name . '.datagrid')
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        {{ $models->links() }}
                    </div>
                    {!! Form::hidden('entity', $name) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
