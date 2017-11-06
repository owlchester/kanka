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
                    <a href="{{ route('journals.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ trans('journals.index.add') }}
                    </a>

                    <div class="box-tools">

                        @include('layouts.datagrid.search', ['route' => route('journals.index')])
                    </div>
                </div>

                <div class="box-body no-padding">
                    <table id="journals" class="table table-hover">
                        <tbody><tr>
                            <th><a href="{{ route('journals.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('journals.fields.name') }}</a></th>
                            <th><a href="{{ route('journals.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('journals.fields.type') }}</a></th>
                            <th><a href="{{ route('journals.index', ['order' => 'date', 'page' => request()->get('page')]) }}">{{ trans('journals.fields.date') }}</a></th>
                            <th>&nbsp;</th>
                        </tr>
                        @foreach ($models as $model)
                        <tr>
                            <td>
                                <a href="{{ route('journals.show', $model->id) }}">{{ $model->name }}</a>
                            </td>
                            <td>{{ $model->type }}</td>
                            <td>{{ $model->date }}</td>
                            <td class="text-right">
                                <a href="{{ route('journals.show', ['id' => $model->id]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody></table>

                    {{ $models->appends('order', request()->get('order'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
