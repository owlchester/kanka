@extends('layouts.app', [
    'title' => trans($name . '.index.title', ['name' => CampaignLocalization::getCampaign()->name]),
    'description' => trans($name . '.index.description',  ['name' => CampaignLocalization::getCampaign()->name]),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    <div class="row margin-bottom">
        <div class="col-md-12">
            @include('layouts.datagrid.search', ['route' => route($name . '.index')])

            @can('create', $model)
                <a href="{{ route($name . '.create') }}" class="btn btn-primary pull-right">
                    <i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">{{ trans($name . '.index.add') }}</span>
                </a>
            @endcan
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
        {!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
        <div class="box-body">
            <p class="help-block">{{ __($view . '.helpers.nested') }}</p>
        </div>

        <div class="box-body no-padding">
            {!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
            @include($name . '._tree')
        </div>
        <div class="box-footer">

            @if(auth()->check())
                <div class="datagrid-bulk-actions" style="display: none">
                @can('delete', $model)
                    {!! Form::button('<i class="fa fa-trash"></i> ' . trans('crud.remove'), ['type' => 'submit', 'name' => 'delete', 'class' => 'btn btn-danger', 'id' => 'crud-multi-delete']) !!}
                @endcan
                    {!! Form::button('<i class="fa fa-download"></i> ' . trans('crud.export'), ['type' => 'submit', 'name' => 'export', 'class' => 'btn btn-primary', 'id' => 'crud-multi-export']) !!}
                @if (Auth::user()->isAdmin())
                    {!! Form::button('<i class="fa fa-lock"></i> ' . trans('crud.actions.private'), ['type' => 'submit', 'name' => 'private', 'class' => 'btn btn-primary', 'id' => 'crud-multi-private']) !!}
                    {!! Form::button('<i class="fa fa-unlock"></i> ' . trans('crud.actions.public'), ['type' => 'submit', 'name' => 'public', 'class' => 'btn btn-primary', 'id' => 'crud-multi-public']) !!}
                @endif
                </div>
            @endif

            <div class="pull-right">
                {{ $models->appends('parent_id', request()->get('parent_id'))->links() }}
            </div>
        </div>
        {!! Form::hidden('entity', $name) !!}
        {!! Form::close() !!}
    </div>

    <input type="hidden" id="{{ $view }}-treeview" value="1" data-url="{{ route($route . '.tree') }}">
@endsection
