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

                @include('cruds._filters', ['route' => route($name . '.tree'), 'filters' => $filters])

                {!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
                <div class="box-body no-padding">
                    @include($name . '._tree')
                </div>
                <div class="box-footer">

                    @can('delete', $model)
                        {!! Form::button('<i class="fa fa-trash"></i> ' . trans('crud.remove'), ['type' => 'submit', 'name' => 'delete', 'class' => 'btn btn-danger', 'style' => 'display:none', 'id' => 'crud-multi-delete']) !!}
                    @endcan
                    @if (Auth::user()->isAdmin())
                        {!! Form::button('<i class="fa fa-lock"></i> ' . trans('crud.actions.private'), ['type' => 'submit', 'name' => 'private', 'class' => 'btn btn-primary', 'style' => 'display:none', 'id' => 'crud-multi-private']) !!}
                        {!! Form::button('<i class="fa fa-unlock"></i> ' . trans('crud.actions.public'), ['type' => 'submit', 'name' => 'public', 'class' => 'btn btn-primary', 'style' => 'display:none', 'id' => 'crud-multi-public']) !!}
                    @endif

                    <div class="pull-right">
                        {{ $models->appends('parent_id', request()->get('parent_id'))->links() }}
                    </div>
                </div>
                {!! Form::hidden('entity', $name) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <input type="hidden" id="location-treeview" value="1" data-url="{{ route('locations.tree') }}">
@endsection
