@extends('layouts.admin', [
    'title' => trans($name . '.index.title'),
    'description' => trans($name . '.index.description'),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    <div class="row margin-bottom">
        <div class="col-md-12">
            @include('layouts.datagrid.search', ['route' => route($name . '.index')])

            @foreach ($actions as $action)
                @if (empty($action['policy']) || (Auth::check() && Auth::user()->can($action['policy'], $model)))
                    <a href="{{ $action['route'] }}" class="btn pull-right btn-{{ $action['class'] }} margin-r-5">
                        {!! $action['label'] !!}
                    </a>
                @endif
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
                {{ $models->links() }}
            </div>
            {!! Form::hidden('entity', $name) !!}
        </div>
    </div>
@endsection
